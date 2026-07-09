@extends('layouts.admin')

@section('title', 'داشبورد مدیریت')

@section('content')
<div class="space-y-6">

    {{-- Welcome heading --}}
    <div>
        <h1 class="text-2xl font-bold text-brand-charcoal">خوش آمدید، مدیر سیستم</h1>
        <p class="text-sm text-gray-500 mt-1">نمای کلی وضعیت فروشگاه خانه‌ی موتور در یک نگاه</p>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-admin.partials.stat-card
            icon="shopping-cart"
            iconBg="bg-red-50"
            iconColor="text-brand-red"
            :value="\App\Support\Format::digits($ordersToday)"
            label="سفارش‌های امروز"
            link="#"
            linkText="مشاهده سفارش‌ها" />

        <x-admin.partials.stat-card
            icon="coins"
            iconBg="bg-orange-50"
            iconColor="text-brand-orange"
            :value="\App\Support\Format::price($revenueToday)"
            label="درآمد امروز (تومان)"
            link="#"
            linkText="مشاهده گزارش" />

        <x-admin.partials.stat-card
            icon="package"
            iconBg="bg-gray-100"
            iconColor="text-brand-charcoal"
            :value="\App\Support\Format::digits($productsCount)"
            label="تعداد محصولات"
            link="#"
            linkText="مشاهده همه" />

        <x-admin.partials.stat-card
            icon="alert-triangle"
            iconBg="bg-amber-50"
            iconColor="text-amber-500"
            :value="\App\Support\Format::digits($lowStockCount)"
            label="هشدار موجودی کم"
            link="#"
            linkText="مشاهده جزئیات" />
    </div>

    {{-- Orders table + chart --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2">
            @include('admin.partials.recent-orders')
        </div>
        <div class="xl:col-span-1">
            @include('admin.partials.revenue-chart')
        </div>
    </div>

    {{-- Low stock warnings --}}
    <div>
        @include('admin.partials.low-stock')
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.anime) {
            anime({
                targets: '.grid > div',
                opacity: [0, 1],
                translateY: [12, 0],
                duration: 500,
                delay: anime.stagger(80),
                easing: 'easeOutCubic',
            });
        }
    });
</script>
@endpush
@endsection
