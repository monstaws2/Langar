@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-right">
        <h1 class="text-3xl font-extrabold text-brand-charcoal">پرداخت و تکمیل سفارش</h1>
        <p class="text-gray-500 mt-2">لطفاً اطلاعات خود را وارد کنید و سفارش خود را نهایی کنید.</p>
    </div>

    @if(count($cartItems) === 0)
        <!-- Empty cart state -->
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <div class="w-20 h-20 rounded-full bg-brand-offwhite flex items-center justify-center mx-auto mb-6">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="text-2xl font-bold text-brand-charcoal mb-4">سبد خرید شما خالی است</h2>
            <p class="text-gray-500 mb-6">برای خرید محصول، ابتدا به صفحه محصولات بروید و موارد مورد نظر خود را به سبد خرید اضافه کنید.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                بازگشت به محصولات
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-brand-charcoal mb-6 text-right">خلاصه سفارش</h2>

                @foreach($cartItems as $item)
                    <div class="flex items-center gap-4 py-4 border-b border-gray-100 last:border-b-0">
                        <!-- Product Image -->
                        <div class="w-16 h-16 flex-shrink-0 rounded-xl bg-brand-offwhite flex items-center justify-center">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <i data-lucide="{{ $item['category_icon'] }}" class="w-8 h-8 text-brand-charcoal/30"></i>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1 min-w-0 text-right">
                            <a href="{{ route('products.show', $item['id']) }}" class="font-bold text-brand-charcoal hover:text-brand-red transition line-clamp-2 block mb-1">
                                {{ $item['name'] }}
                            </a>
                            <div class="text-sm text-gray-500">
                                {{ $item['quantity'] }} × {{ \App\Support\Format::price($item['price']) }} تومان
                            </div>
                        </div>

                        <!-- Subtotal -->
                        <div class="text-center w-24 font-num font-bold text-brand-charcoal">
                            {{ \App\Support\Format::price($item['line_total']) }}
                        </div>
                    </div>
                @endforeach

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>جمع کل:</span>
                        <span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::price($total) }} تومان</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال:</span>
                        <span class="text-green-600 font-semibold">رایگان</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-brand-charcoal mb-6 text-right">اطلاعات تحویل</h2>

                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">نام و نام خانوادگی *</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">شماره تماس *</label>
                            <input type="tel" name="phone" id="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm"
                                   required>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">آدرس *</label>
                            <textarea name="address" id="address" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">شهر *</label>
                            <input type="text" name="city" id="city"
                                   value="{{ old('city') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm"
                                   required>
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">کد پستی *</label>
                            <input type="text" name="postal_code" id="postal_code"
                                   value="{{ old('postal_code') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm"
                                   required>
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-gray-100">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submitButton">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            تکمیل سفارش و پرداخت
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;

            var el = document.getElementById('checkoutForm') || document.querySelector('.empty-cart-state');
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