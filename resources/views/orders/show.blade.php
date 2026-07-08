@extends('layouts.app')

@section('title', 'جزئیات سفارش #' . $order->id)

@php
$statusConfig = [
    'pending' => ['label' => 'در انتظار تأیید', 'class' => 'bg-amber-50 text-amber-700 border-amber-200', 'icon' => 'clock'],
    'paid' => ['label' => 'پرداخت شده', 'class' => 'bg-blue-50 text-blue-700 border-blue-200', 'icon' => 'credit-card'],
    'shipped' => ['label' => 'ارسال شده', 'class' => 'bg-purple-50 text-purple-700 border-purple-200', 'icon' => 'truck'],
    'delivered' => ['label' => 'تحویل شده', 'class' => 'bg-green-50 text-green-700 border-green-200', 'icon' => 'check-circle'],
    'cancelled' => ['label' => 'لغو شده', 'class' => 'bg-red-50 text-red-700 border-red-200', 'icon' => 'x-circle'],
];
$status = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-50 text-gray-700 border-gray-200', 'icon' => 'help-circle'];
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('dashboard') }}" class="hover:text-brand-red transition">حساب کاربری</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('orders.index') }}" class="hover:text-brand-red transition">سفارش‌های من</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">سفارش #{{ \App\Support\Format::digits($order->id) }}</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">سفارش #{{ \App\Support\Format::digits($order->id) }}</h1>
            <p class="text-gray-500 mt-1 text-sm">ثبت شده در {{ $order->created_at->format('Y/m/d H:i') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium border {{ $status['class'] }}">
                <i data-lucide="{{ $status['icon'] }}" class="w-4 h-4"></i>
                {{ $status['label'] }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Order Items --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-brand-charcoal flex items-center gap-2">
                        <i data-lucide="package" class="w-5 h-5 text-gray-400"></i>
                        محصولات سفارش
                    </h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($order->items as $item)
                        <div class="px-6 py-4 flex items-center gap-4">
                            <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                <i data-lucide="package" class="w-6 h-6 text-gray-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-brand-charcoal text-sm truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 font-num">{{ \App\Support\Format::price($item->price) }} تومان × {{ \App\Support\Format::digits($item->quantity) }}</p>
                            </div>
                            <div class="text-left shrink-0">
                                <p class="font-num font-medium text-brand-charcoal text-sm">{{ \App\Support\Format::price($item->total_price) }} تومان</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-6 py-4 bg-gray-50 rounded-b-xl border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-brand-charcoal">مجموع</span>
                        <span class="font-bold text-brand-charcoal font-num text-lg">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Info Sidebar --}}
        <div class="space-y-6">
            {{-- Shipping Info --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-bold text-brand-charcoal mb-4 flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
                    اطلاعات ارسال
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 shrink-0 w-16">نام:</span>
                        <span class="text-brand-charcoal font-medium">{{ $order->name }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 shrink-0 w-16">تلفن:</span>
                        <span class="text-brand-charcoal font-num" dir="ltr">{{ $order->phone }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 shrink-0 w-16">شهر:</span>
                        <span class="text-brand-charcoal">{{ $order->city }}</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-gray-400 shrink-0 w-16">آدرس:</span>
                        <span class="text-brand-charcoal leading-relaxed">{{ $order->address }}</span>
                    </div>
                    @if($order->postal_code)
                        <div class="flex items-start gap-3">
                            <span class="text-gray-400 shrink-0 w-16">کد پستی:</span>
                            <span class="text-brand-charcoal font-num" dir="ltr">{{ $order->postal_code }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Status Timeline --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-bold text-brand-charcoal mb-4 flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-gray-400"></i>
                    وضعیت سفارش
                </h3>
                <div class="space-y-0">
                    @php
                        $steps = [
                            ['key' => 'pending', 'label' => 'ثبت سفارش', 'desc' => 'سفارش شما ثبت شد'],
                            ['key' => 'paid', 'label' => 'پرداخت', 'desc' => 'پرداخت انجام شد'],
                            ['key' => 'shipped', 'label' => 'ارسال', 'desc' => 'سفارش ارسال شد'],
                            ['key' => 'delivered', 'label' => 'تحویل', 'desc' => 'سفارش تحویل داده شد'],
                        ];
                        $statusOrder = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];
                        $currentStatusIndex = array_search($order->status, $statusOrder);
                        $isCancelled = $order->status === 'cancelled';
                    @endphp

                    @if($isCancelled)
                        <div class="flex items-start gap-3 py-2">
                            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="x" class="w-3 h-3 text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-red-600">سفارش لغو شده</p>
                                <p class="text-xs text-gray-400">این سفارش لغو شده است</p>
                            </div>
                        </div>
                    @else
                        @foreach($steps as $index => $step)
                            @php
                                $stepIndex = array_search($step['key'], $statusOrder);
                                $isActive = $stepIndex <= $currentStatusIndex;
                                $isCurrent = $step['key'] === $order->status;
                            @endphp
                            <div class="flex items-start gap-3 py-2 {{ !$loop->last ? 'border-r-2 border-gray-100 mr-3 pr-6' : 'mr-3 pr-6' }} {{ $isActive ? '!border-brand-red' : '' }}">
                                <div class="w-6 h-6 rounded-full {{ $isActive ? 'bg-brand-red' : 'bg-gray-200' }} flex items-center justify-center shrink-0 -mr-[41px]">
                                    @if($isActive)
                                        <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                    @else
                                        <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                    @endif
                                </div>
                                <div class="mr-2">
                                    <p class="text-sm font-medium {{ $isActive ? 'text-brand-charcoal' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                                    <p class="text-xs {{ $isActive ? 'text-gray-500' : 'text-gray-300' }}">{{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <a href="{{ route('orders.index') }}" class="flex items-center justify-center gap-2 w-full border border-gray-200 text-gray-600 hover:bg-gray-50 px-4 py-2.5 rounded-lg text-sm transition">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    <span>بازگشت به لیست سفارش‌ها</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
