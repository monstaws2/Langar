@php
    $totalQuantity = array_reduce($cartItems, fn($c, $i) => $c + $i->quantity, 0);
@endphp

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
                بازگشت به محصولات
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-content">
            <!-- Items column -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-5">
                        <div class="flex items-center gap-4">
                            <!-- Product image / icon -->
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-brand-offwhite flex items-center justify-center shrink-0">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <i data-lucide="{{ $item->category_icon }}" class="w-8 h-8 sm:w-10 sm:h-10 text-brand-charcoal/30"></i>
                                @endif
                            </div>

                            <!-- Product info -->
                            <div class="flex-1 min-w-0 text-right">
                                <a href="{{ route('products.show', $item->slug) }}" class="font-bold text-brand-charcoal hover:text-brand-red transition line-clamp-2">
                                    {{ $item->name }}
                                </a>
                                <div class="mt-2 font-num text-brand-red font-bold">
                                    {{ \App\Support\Format::price($item->price) }}
                                    <span class="text-xs font-normal text-gray-500">تومان</span>
                                </div>

                                <!-- Mobile remove -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-2 sm:hidden">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 text-xs text-brand-red hover:text-brand-red-dark transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        حذف
                                    </button>
                                </form>
                            </div>

                            <!-- Desktop: quantity, subtotal, remove -->
                            <div class="hidden sm:flex items-center gap-5">
                                <!-- Quantity + update -->
                                <div class="text-center">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1.5">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                            min="1" max="999"
                                            class="w-16 text-center border border-gray-200 rounded-lg py-1.5 text-sm font-num focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 bg-brand-orange hover:bg-brand-orange-dark text-white rounded-lg text-xs font-bold transition"
                                            aria-label="به‌روزرسانی">
                                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-center min-w-[90px]">
                                    <div class="font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($item->line_total) }}</div>
                                    <div class="text-xs text-gray-400">تومان</div>
                                </div>

                                <!-- Desktop remove -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-brand-red hover:bg-red-50 transition"
                                        aria-label="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Mobile: quantity + subtotal -->
                        <div class="sm:hidden flex items-center justify-between gap-3 mt-3 pt-3 border-t border-gray-100">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1.5">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}"
                                    min="1" max="999"
                                    class="w-14 text-center border border-gray-200 rounded-lg py-1 text-sm font-num focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-7 h-7 bg-brand-orange hover:bg-brand-orange-dark text-white rounded-lg text-xs font-bold transition">
                                    <i data-lucide="check" class="w-3 h-3"></i>
                                </button>
                            </form>
                            <div class="text-right">
                                <div class="text-xs text-gray-400">جمع</div>
                                <div class="font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($item->line_total) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Clear cart -->
                <div class="text-right">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" onclick="return confirm('آیا از پاک کردن سبد خرید اطمینان دارید؟')"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm text-brand-red hover:bg-red-50 rounded-lg transition">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            پاک کردن سبد خرید
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary sidebar -->
            <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
                <h2 class="text-xl font-bold text-brand-charcoal mb-6">خلاصه سفارش</h2>
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-600">
                        <span>تعداد کالا:</span>
                        <span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::digits($totalQuantity) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>جمع کل:</span>
                        <span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::price($total) }} <span class="text-xs font-normal text-gray-400">تومان</span></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال:</span>
                        <span class="text-green-600 font-semibold">رایگان</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 space-y-3">
                        <button class="w-full inline-flex items-center justify-center gap-2 bg-brand-red hover:bg-brand-red-dark text-white py-3 rounded-lg font-bold transition">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            تکمیل سفارش
                        </button>
                        <a href="{{ route('products.index') }}"
                            class="block text-center w-full inline-flex items-center justify-center gap-2 border border-gray-200 text-brand-charcoal hover:bg-brand-offwhite py-3 rounded-lg font-bold transition">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            ادامه خرید
                        </a>
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
