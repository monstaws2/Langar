@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-right">
        <h1 class="text-3xl font-extrabold text-brand-charcoal">سبد خرید</h1>
        <p class="text-gray-500 mt-2">محصولات انتخابی خود را مرور کنید</p>
    </div>

    @if(count($cartItems) === 0)
        <!-- Empty state -->
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center" id="cart-empty-state">
            <div class="w-20 h-20 rounded-full bg-brand-offwhite flex items-center justify-center mx-auto">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="text-2xl font-bold text-brand-charcoal mt-5">سبد خرید شما خالی است</h2>
            <p class="text-gray-500 mt-2">برای شروع خرید، به صفحه محصولات بروید.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                مشاهده محصولات
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-content">
            <!-- Items -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="hidden sm:grid grid-cols-12 gap-4 bg-brand-offwhite px-6 py-3 text-sm font-semibold text-gray-600">
                    <div class="col-span-6 text-right">محصول</div>
                    <div class="col-span-2 text-center">قیمت</div>
                    <div class="col-span-2 text-center">تعداد</div>
                    <div class="col-span-2 text-center">جمع</div>
                </div>

                @foreach($cartItems as $item)
                    <div class="grid grid-cols-12 gap-4 items-center px-6 py-4 border-b border-gray-100 last:border-b-0">
                        <div class="col-span-12 sm:col-span-6 flex items-center justify-between sm:justify-start gap-3 text-right">
                            <a href="{{ route('products.show', $item->slug) }}" class="font-semibold text-brand-charcoal hover:text-brand-red transition">{{ $item->name }}</a>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="sm:mr-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-xs text-brand-red hover:text-brand-red-dark transition" aria-label="حذف">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    حذف
                                </button>
                            </form>
                        </div>
                        <div class="col-span-4 sm:col-span-2 text-center text-gray-700">
                            <span class="font-num">{{ \App\Support\Format::price($item->price) }}</span>
                            <span class="text-xs text-gray-400">تومان</span>
                        </div>
                        <div class="col-span-4 sm:col-span-2 text-center font-num text-gray-700">{{ \App\Support\Format::digits($item->quantity) }}</div>
                        <div class="col-span-4 sm:col-span-2 text-center font-bold text-brand-charcoal">
                            <span class="font-num">{{ \App\Support\Format::price($item->line_total) }}</span>
                            <span class="text-xs font-normal text-gray-400">تومان</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
                <h2 class="text-xl font-bold text-brand-charcoal mb-6">خلاصه سفارش</h2>
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-600">
                        <span>جمع کل:</span>
                        <span><span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::price($total) }}</span> تومان</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال:</span>
                        <span class="text-green-600 font-semibold">رایگان</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <button class="w-full inline-flex items-center justify-center gap-2 bg-brand-red hover:bg-brand-red-dark text-white py-3 rounded-lg font-bold transition">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            تکمیل سفارش
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;

            var el = document.getElementById('cart-empty-state') || document.getElementById('cart-content');
            if (el) {
                anime({
                    targets: el,
                    translateY: [20, 0],
                    opacity: [0, 1],
                    duration: 650,
                    easing: 'easeOutCubic'
                });
            }
        });
    </script>
@endpush
@endsection
