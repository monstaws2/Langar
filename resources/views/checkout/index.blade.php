@extends('layouts.app')

@section('title', 'تکمیل سفارش')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('cart.index') }}" class="hover:text-brand-red transition">سبد خرید</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">تکمیل سفارش</span>
    </nav>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-brand-charcoal">تکمیل سفارش</h1>
        <p class="text-gray-500 mt-1 text-sm">اطلاعات ارسال را وارد کنید تا سفارش خود را نهایی کنید.</p>
    </div>

    @if(count($cartItems) === 0)
        <!-- Empty cart state -->
        <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="text-xl font-bold text-brand-charcoal mb-2">سبد خرید شما خالی است</h2>
            <p class="text-gray-500 mb-6">برای خرید، ابتدا محصولات مورد نظر خود را به سبد اضافه کنید.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                مشاهده محصولات
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-brand-charcoal mb-6 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-5 h-5 text-gray-400"></i>
                    اطلاعات تحویل
                </h2>

                <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">نام و نام خانوادگی *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                   class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-brand-red/30 text-sm
                                   @error('name') border-red-500 focus:border-red-500 @else border-gray-200 focus:border-brand-red @enderror">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">شماره تماس *</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" dir="ltr"
                                   class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-brand-red/30 text-sm font-num
                                   @error('phone') border-red-500 focus:border-red-500 @else border-gray-200 focus:border-brand-red @enderror">
                            @error('phone')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">آدرس کامل *</label>
                        <textarea name="address" id="address" rows="3"
                                  class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-brand-red/30 text-sm
                                  @error('address') border-red-500 focus:border-red-500 @else border-gray-200 focus:border-brand-red @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{
                        province: '{{ old('province') }}',
                        city: '{{ old('city') }}',
                        cities: []
                    }" x-init="
                        let found = window.iranLocations.find(p => p.province === province);
                        if (found) { cities = found.cities }
                    ">
                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700 mb-1">استان *</label>
                            <select name="province" id="province" x-model="province"
                                    @change="
                                        let match = window.iranLocations.find(p => p.province === province);
                                        cities = match ? match.cities : [];
                                        city = '';
                                    "
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-brand-red/30 text-sm bg-white
                                    @error('province') border-red-500 focus:border-red-500 @else border-gray-200 focus:border-brand-red @enderror">
                                <option value="">انتخاب استان</option>
                                <template x-for="p in window.iranLocations" :key="p.province">
                                    <option :value="p.province" x-text="p.province" :selected="p.province === province"></option>
                                </template>
                            </select>
                            @error('province')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">شهر *</label>
                            <select name="city" id="city" x-model="city" :disabled="cities.length === 0"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-brand-red/30 text-sm bg-white disabled:bg-gray-50 disabled:text-gray-400
                                    @error('city') border-red-500 focus:border-red-500 @else border-gray-200 focus:border-brand-red @enderror">
                                <option value="">ابتدا استان را انتخاب کنید</option>
                                <template x-for="c in cities" :key="c">
                                    <option :value="c" x-text="c" :selected="c === city"></option>
                                </template>
                            </select>
                            @error('city')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">کد پستی *</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" dir="ltr"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-brand-red/30 text-sm font-num
                               @error('postal_code') border-red-500 focus:border-red-500 @else border-gray-200 focus:border-brand-red @enderror">
                        @error('postal_code')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-brand-red hover:bg-red-700 text-white rounded-xl font-bold transition text-sm">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            تکمیل سفارش
                        </button>
                        <p class="text-xs text-gray-400 text-center mt-3">با کلیک روی دکمه بالا، سفارش شما ثبت و به صورت پرداخت در محل تکمیل می‌شود.</p>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24">
                    <h2 class="font-bold text-brand-charcoal mb-4 flex items-center gap-2">
                        <i data-lucide="receipt" class="w-5 h-5 text-gray-400"></i>
                        خلاصه سفارش
                    </h2>

                    <div class="divide-y divide-gray-100 mb-4 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-3 py-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                    <i data-lucide="{{ $item['category_icon'] }}" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-brand-charcoal truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-400 font-num">{{ \App\Support\Format::digits($item['quantity']) }} × {{ \App\Support\Format::price($item['price']) }}</p>
                                </div>
                                <span class="font-num text-sm font-medium">{{ \App\Support\Format::price($item['line_total']) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">جمع کل</span>
                            <span class="font-num font-medium">{{ \App\Support\Format::price($total) }} تومان</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">هزینه ارسال</span>
                            @if($total >= 500000)
                                <span class="text-green-600 font-medium">رایگان</span>
                            @else
                                <span class="font-num font-medium">۳۵٬۰۰۰ تومان</span>
                            @endif
                        </div>
                        <div class="border-t border-gray-100 pt-2 flex justify-between">
                            <span class="font-bold text-brand-charcoal">مبلغ قابل پرداخت</span>
                            <span class="font-bold text-brand-red font-num">
                                {{ \App\Support\Format::price($total >= 500000 ? $total : $total + 35000) }} تومان
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection