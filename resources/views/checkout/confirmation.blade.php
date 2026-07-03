@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-extrabold text-brand-charcoal">سفارش شما با موفقیت ثبت شد!</h1>
        <p class="text-gray-500 mt-2">شماره سفارش: <span class="font-bold text-brand-red">{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm">
        <!-- Order Details -->
        <div class="p-6">
            <h2 class="text-xl font-bold text-brand-charcoal mb-6 text-right">جزئیات سفارش</h2>

            <!-- Customer Info -->
            <div class="mb-6 p-4 bg-brand-offwhite rounded-xl">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-3">اطلاعات مشتری</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>نام:</span>
                        <span class="font-num">{{ $order->name }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>شماره تماس:</span>
                        <span class="font-num">{{ $order->phone }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>آدرس:</span>
                        <span class="break-all font-num">{{ $order->address }}, {{ $order->city }}, کد پستی: {{ $order->postal_code }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-4 text-right">محصولات سفارش شده</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <!-- Product Image -->
                            <div class="w-16 h-16 flex-shrink-0 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                @php
                                    $product = $item->product;
                                    $image = $product ? $product->image : null;
                                    $icon = $product && $product->category ? $product->category->icon : 'package';
                                @endphp
                                @if($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="" class="w-full h-full object-contain rounded">
                                @else
                                    <i data-lucide="{{ $icon }}" class="w-8 h-8 text-brand-charcoal/30"></i>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0 text-right">
                                <div class="font-bold text-brand-charcoal">{{ $item->product_name }}</div>
                                <div class="text-sm text-gray-600">
                                    @if($item->product)
                                        {{ $item->product->brand->name ?? '' }}
                                    @endif
                                </div>
                            </div>

                            <!-- Quantity & Price -->
                            <div class="text-center space-x-3">
                                <div class="font-num text-gray-600">{{ $item->quantity }} عدد</div>
                                <div class="font-bold text-brand-charcoal">{{ \App\Support\Format::price($item->price) }} تومان</div>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-center w-24 font-bold text-brand-charcoal">
                                {{ \App\Support\Format::price($item->price * $item->quantity) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="p-4 bg-brand-offwhite rounded-xl">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-3">جمع کل سفارش</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>جمع محصولات:</span>
                        <span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال:</span>
                        <span class="text-green-600 font-semibold">رایگان</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3">
                        <div class="flex justify-between text-gray-600 font-bold">
                            <span>مبلغ قابل پرداخت:</span>
                            <span class="font-num font-bold text-brand-red text-xl">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-6 pt-0">
            <div class="space-y-4">
                <a href="{{ route('products.index') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    بازگشت به فروشگاه
                </a>

                @auth
                    <a href="{{ route('profile.edit') }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 border border-gray-200 text-brand-charcoal hover:bg-brand-offwhite rounded-lg font-bold transition">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        مشاهده حساب کاربری
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;

            var els = document.querySelectorAll('.order-details, .order-actions');
            els.forEach(function(el) {
                anime({
                    targets: el,
                    translateY: [20, 0],
                    opacity: [0, 1],
                    duration: 650,
                    easing: 'easeOutCubic',
                    delay: anime.stagger(100)
                });
            });
        });
    </script>
@endpush
@endsection