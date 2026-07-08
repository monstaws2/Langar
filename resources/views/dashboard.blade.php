@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">حساب کاربری</span>
    </nav>

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-brand-charcoal">حساب کاربری</h1>
        <p class="text-gray-500 mt-1">خوش آمدید، <span class="font-medium text-brand-charcoal">{{ auth()->user()->name }}</span></p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-blue-600"></i>
                </div>
                <span class="text-sm text-gray-500">کل سفارش‌ها</span>
            </div>
            <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($stats['total_orders']) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5 text-amber-600"></i>
                </div>
                <span class="text-sm text-gray-500">در انتظار تأیید</span>
            </div>
            <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($stats['pending_orders']) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                </div>
                <span class="text-sm text-gray-500">تحویل شده</span>
            </div>
            <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($stats['delivered_orders']) }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-brand-red/10 flex items-center justify-center">
                    <i data-lucide="wallet" class="w-5 h-5 text-brand-red"></i>
                </div>
                <span class="text-sm text-gray-500">مجموع خرید</span>
            </div>
            <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($stats['total_spent']) }} <span class="text-sm font-normal text-gray-400">تومان</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Recent Orders --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-brand-charcoal">آخرین سفارش‌ها</h2>
                    <a href="{{ route('orders.index') }}" class="text-sm text-brand-red hover:underline flex items-center gap-1">
                        مشاهده همه
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    </a>
                </div>

                @if($orders->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($orders as $order)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <i data-lucide="package" class="w-5 h-5 text-gray-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-brand-charcoal text-sm">سفارش #{{ \App\Support\Format::digits($order->id) }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm font-num font-medium text-brand-charcoal">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['label' => 'در انتظار', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                            'paid' => ['label' => 'پرداخت شده', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                            'shipped' => ['label' => 'ارسال شده', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
                                            'delivered' => ['label' => 'تحویل شده', 'class' => 'bg-green-50 text-green-700 border-green-200'],
                                            'cancelled' => ['label' => 'لغو شده', 'class' => 'bg-red-50 text-red-700 border-red-200'],
                                        ];
                                        $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-50 text-gray-700 border-gray-200'];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium border {{ $status['class'] }}">{{ $status['label'] }}</span>
                                    <a href="{{ route('orders.show', $order) }}" class="text-brand-red hover:text-brand-red/80 transition">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="package-open" class="w-8 h-8 text-gray-300"></i>
                        </div>
                        <p class="text-gray-500 mb-2">هنوز سفارشی ثبت نکرده‌اید</p>
                        <a href="{{ route('products.index') }}" class="text-brand-red hover:underline text-sm">مشاهده محصولات</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Links Sidebar --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-bold text-brand-charcoal mb-4">دسترسی سریع</h3>
                <div class="space-y-2">
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-brand-charcoal transition">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400"></i>
                        <span>سفارش‌های من</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-brand-charcoal transition">
                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                        <span>ویرایش پروفایل</span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-brand-charcoal transition">
                        <i data-lucide="shopping-cart" class="w-4 h-4 text-gray-400"></i>
                        <span>سبد خرید</span>
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-gray-50 hover:text-brand-charcoal transition">
                        <i data-lucide="store" class="w-4 h-4 text-gray-400"></i>
                        <span>فروشگاه</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="font-bold text-brand-charcoal mb-3">نیاز به کمک دارید؟</h3>
                <p class="text-sm text-gray-500 mb-4">برای هرگونه سوال یا مشکل، با ما در تماس باشید.</p>
                <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 text-sm text-brand-red hover:underline">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span>تماس با ما</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
