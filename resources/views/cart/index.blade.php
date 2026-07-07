@php
    $totalQuantity = array_reduce($cartItems, fn($c, $i) => $c + $i->quantity, 0);
@endphp

@extends('layouts.app')

@section('title', 'سبد خرید')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">سبد خرید</span>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">سبد خرید</h1>
            <p class="text-gray-500 mt-1 text-sm">
                @if(count($cartItems) > 0)
                    {{ \App\Support\Format::digits($totalQuantity) }} کالا در سبد شما
                @else
                    محصولات انتخابی خود را مرور کنید
                @endif
            </p>
        </div>
        @if(count($cartItems) > 0)
            <form action="{{ route('cart.clear') }}" method="POST" class="hidden sm:block">
                @csrf
                <button type="submit" onclick="return confirm('آیا از پاک کردن سبد خرید اطمینان دارید؟')"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition border border-red-200">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    پاک کردن سبد
                </button>
            </form>
        @endif
    </div>

    @if(count($cartItems) === 0)
        {{-- Empty State --}}
        <div class="bg-white rounded-xl border border-gray-200 py-16 text-center" id="cart-empty-state">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="text-xl font-bold text-brand-charcoal mb-2">سبد خرید شما خالی است</h2>
            <p class="text-gray-500 mb-6 max-w-sm mx-auto">محصولات مورد علاقه خود را به سبد اضافه کنید و خرید خود را تکمیل نمایید.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                مشاهده محصولات
            </a>
        </div>
    @else
        @php
            $hasStockIssue = collect($cartItems)->contains(fn($item) => $item->exceeds_stock || $item->out_of_stock);
        @endphp

        @if($hasStockIssue)
            <div class="mb-6 flex items-center gap-3 rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-amber-800">
                <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                <span class="text-sm">برخی از محصولات سبد شما با مشکل موجودی مواجه شده‌اند. لطفاً قبل از ادامه، تعداد را اصلاح کنید.</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" id="cart-content">
            <div class="lg:col-span-2 space-y-3">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-xl border border-gray-200 p-4 sm:p-5 {{ $item->out_of_stock || $item->exceeds_stock ? 'border-red-300 bg-red-50/30' : '' }}">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <i data-lucide="{{ $item->category_icon }}" class="w-8 h-8 text-gray-300"></i>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->slug) }}" class="font-medium text-brand-charcoal hover:text-brand-red transition text-sm line-clamp-2">
                                    {{ $item->name }}
                                </a>
                                <div class="mt-1 font-num text-brand-red font-bold text-sm">
                                    {{ \App\Support\Format::price($item->price) }} <span class="text-xs font-normal text-gray-400">تومان</span>
                                </div>

                                @if($item->out_of_stock)
                                    <span class="inline-flex items-center gap-1 text-xs text-red-600 mt-1">
                                        <i data-lucide="x-circle" class="w-3 h-3"></i> ناموجود
                                    </span>
                                @elseif($item->exceeds_stock)
                                    <span class="inline-flex items-center gap-1 text-xs text-amber-600 mt-1">
                                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> بیشتر از موجودی ({{ \App\Support\Format::digits($item->stock) }} عدد موجود)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs text-green-600 mt-1">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> {{ \App\Support\Format::digits($item->stock) }} عدد موجود
                                    </span>
                                @endif
                            </div>

                            <div class="hidden sm:flex items-center gap-4">
                                {{-- Quantity controls (form-based for stock validation) --}}
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                            class="w-8 h-8 rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-brand-charcoal disabled:opacity-30 transition">
                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                    </button>
                                    <span class="w-8 text-center font-num text-sm font-medium">{{ \App\Support\Format::digits($item->quantity) }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                            {{ $item->quantity >= $item->stock ? 'disabled' : '' }}
                                            class="w-8 h-8 rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-brand-charcoal disabled:opacity-30 transition">
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </form>

                                <div class="text-center min-w-[80px]">
                                    <span class="font-bold text-brand-charcoal font-num text-sm">{{ \App\Support\Format::price($item->line_total) }}</span>
                                    <span class="text-xs text-gray-400">تومان</span>
                                </div>

                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition" aria-label="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Mobile quantity controls --}}
                        <div class="sm:hidden flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                        class="w-7 h-7 rounded border border-gray-200 bg-gray-50 flex items-center justify-center disabled:opacity-30">
                                    <i data-lucide="minus" class="w-3 h-3"></i>
                                </button>
                                <span class="w-6 text-center font-num text-sm">{{ \App\Support\Format::digits($item->quantity) }}</span>
                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                        {{ $item->quantity >= $item->stock ? 'disabled' : '' }}
                                        class="w-7 h-7 rounded border border-gray-200 bg-gray-50 flex items-center justify-center disabled:opacity-30">
                                    <i data-lucide="plus" class="w-3 h-3"></i>
                                </button>
                            </form>
                            <div class="text-left">
                                <span class="font-bold text-brand-charcoal font-num text-sm">{{ \App\Support\Format::price($item->line_total) }} تومان</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Mobile clear cart --}}
                <form action="{{ route('cart.clear') }}" method="POST" class="sm:hidden">
                    @csrf
                    <button type="submit" onclick="return confirm('آیا از پاک کردن سبد خرید اطمینان دارید؟')"
                        class="w-full text-center py-3 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition">
                        پاک کردن سبد خرید
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-24">
                    <h2 class="font-bold text-brand-charcoal mb-4 text-lg">خلاصه سفارش</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">تعداد کالاها</span>
                            <span class="font-num font-medium text-brand-charcoal">{{ \App\Support\Format::digits($totalQuantity) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">تعداد اقلام</span>
                            <span class="font-num font-medium text-brand-charcoal">{{ \App\Support\Format::digits(count($cartItems)) }}</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-medium text-brand-charcoal">مجموع</span>
                            <span class="font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($total) }} تومان</span>
                        </div>
                    </div>

                    @if($total >= 500000)
                        <div class="flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 px-3 py-2 text-green-700 text-xs mb-4">
                            <i data-lucide="truck" class="w-4 h-4 shrink-0"></i>
                            <span>شامل ارسال رایگان</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 rounded-lg bg-blue-50 border border-blue-200 px-3 py-2 text-blue-700 text-xs mb-4">
                            <i data-lucide="info" class="w-4 h-4 shrink-0"></i>
                            <span>{{ \App\Support\Format::price(500000 - $total) }} تومان تا ارسال رایگان</span>
                        </div>
                    @endif

                    @php
                        $canCheckout = !collect($cartItems)->contains(fn($item) => $item->out_of_stock || $item->exceeds_stock);
                    @endphp

                    <a href="{{ route('checkout.index') }}"
                       class="block w-full text-center py-3 rounded-lg font-medium transition {{ $canCheckout ? 'bg-brand-red text-white hover:bg-red-700' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}"
                       @if(!$canCheckout) onclick="event.preventDefault(); alert('لطفاً مشکلات موجودی را برطرف کنید.');" @endif>
                        <span class="flex items-center justify-center gap-2">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            تکمیل خرید
                        </span>
                    </a>

                    <a href="{{ route('products.index') }}" class="block w-full text-center mt-3 text-sm text-gray-500 hover:text-brand-red transition">
                        ادامه خرید
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
