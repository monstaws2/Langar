@extends('layouts.app')

@section('title', 'تأیید سفارش')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 justify-center">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">تأیید سفارش</span>
    </nav>

    {{-- Success Header --}}
    <div class="text-center mb-8">
        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="check-circle-2" class="w-10 h-10 text-green-600"></i>
        </div>
        <h1 class="text-2xl font-bold text-brand-charcoal mb-2">سفارش شما با موفقیت ثبت شد!</h1>
        <p class="text-gray-500">از خرید شما سپاسگزاریم. سفارش شما در اسرع وقت پردازش می‌شود.</p>
    </div>

    {{-- Order Number Card --}}
    <div class="bg-brand-charcoal rounded-xl p-6 text-center mb-6">
        <p class="text-gray-400 text-sm mb-1">شماره سفارش</p>
        <p class="text-3xl font-extrabold text-white font-num tracking-wider">{{ $order->order_number ?? 'KM-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
        <div class="flex items-center justify-center gap-4 mt-3 text-sm">
            <span class="text-gray-400">تاریخ: <span class="text-white font-num">{{ $order->created_at->format('Y/m/d') }}</span></span>
            <span class="text-gray-600">|</span>
            @php
                $statusConfig = [
                    'pending' => ['label' => 'در انتظار تأیید', 'class' => 'text-amber-400'],
                    'paid' => ['label' => 'پرداخت شده', 'class' => 'text-blue-400'],
                    'shipped' => ['label' => 'ارسال شده', 'class' => 'text-purple-400'],
                    'delivered' => ['label' => 'تحویل شده', 'class' => 'text-green-400'],
                    'cancelled' => ['label' => 'لغو شده', 'class' => 'text-red-400'],
                ];
                $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => 'text-gray-400'];
            @endphp
            <span class="text-gray-400">وضعیت: <span class="font-medium {{ $status['class'] }}">{{ $status['label'] }}</span></span>
        </div>
    </div>

    {{-- Order Details --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-brand-charcoal flex items-center gap-2">
                <i data-lucide="package" class="w-5 h-5 text-gray-400"></i>
                محصولات سفارش
            </h2>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($order->items as $item)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                        <i data-lucide="package" class="w-6 h-6 text-gray-400"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-brand-charcoal text-sm">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-400 font-num">{{ \App\Support\Format::digits($item->quantity) }} عدد × {{ \App\Support\Format::price($item->price) }} تومان</p>
                    </div>
                    <span class="font-num font-medium text-sm">{{ \App\Support\Format::price($item->total_price) }} تومان</span>
                </div>
            @endforeach
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <span class="font-bold text-brand-charcoal">مجموع</span>
                <span class="font-bold text-brand-red font-num text-lg">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
            </div>
        </div>
    </div>

    {{-- Shipping Info --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <h2 class="font-bold text-brand-charcoal mb-4 flex items-center gap-2">
            <i data-lucide="map-pin" class="w-5 h-5 text-gray-400"></i>
            اطلاعات ارسال
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-400 block mb-1">نام</span>
                <span class="font-medium text-brand-charcoal">{{ $order->name }}</span>
            </div>
            <div>
                <span class="text-gray-400 block mb-1">تلفن</span>
                <span class="font-num text-brand-charcoal" dir="ltr">{{ $order->phone }}</span>
            </div>
            <div class="sm:col-span-2">
                <span class="text-gray-400 block mb-1">آدرس</span>
                <span class="font-medium text-brand-charcoal">{{ $order->address }}، {{ $order->city }}</span>
            </div>
            <div>
                <span class="text-gray-400 block mb-1">کد پستی</span>
                <span class="font-num text-brand-charcoal" dir="ltr">{{ $order->postal_code }}</span>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('products.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-brand-red text-white hover:bg-red-700 rounded-xl font-medium transition text-sm">
            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
            ادامه خرید
        </a>
        @auth
            <a href="{{ route('orders.show', $order) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-200 text-brand-charcoal hover:border-brand-red hover:text-brand-red rounded-xl transition font-medium text-sm">
                <i data-lucide="eye" class="w-5 h-5"></i>
                مشاهده سفارش
            </a>
        @else
            <a href="{{ route('register') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-200 text-brand-charcoal hover:border-brand-red hover:text-brand-red rounded-xl transition font-medium text-sm">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                ثبت‌نام برای پیگیری سفارش
            </a>
        @endauth
    </div>

    {{-- Help --}}
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-400">
            سوالی دارید؟ <a href="{{ route('contact.index') }}" class="text-brand-red hover:underline">با ما تماس بگیرید</a>
        </p>
    </div>
</div>
@endsection
