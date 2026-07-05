@extends('layouts.admin')

@section('title', 'مدیریت مشتریان')

@section('content')
<div class="space-y-6" x-data="{ customerFilter: '{{ request('filter', '') }}' }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">مشتریان</h1>
            <p class="text-sm text-gray-500 mt-1">مدیریت و مشاهده مشتریان فروشگاه</p>
        </div>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($totalCustomers) }}</p>
                    <p class="text-xs text-gray-500">کل مشتریان</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                    <i data-lucide="user-plus" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($newThisMonth) }}</p>
                    <p class="text-xs text-gray-500">مشتری جدید این ماه</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($withOrders) }}</p>
                    <p class="text-xs text-gray-500">مشتری با سفارش</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <i data-lucide="coins" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($totalRevenue) }}</p>
                    <p class="text-xs text-gray-500">درآمد کل (تومان)</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 sm:p-5">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجوی نام یا ایمیل..." class="w-full bg-gray-50 rounded-lg pr-9 pl-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
            </div>
            <select name="filter" x-model="customerFilter" class="bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                <option value="">همه مشتریان</option>
                <option value="with_orders" {{ request('filter') === 'with_orders' ? 'selected' : '' }}>دارای سفارش</option>
                <option value="without_orders" {{ request('filter') === 'without_orders' ? 'selected' : '' }}>بدون سفارش</option>
                <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }}>ثبت‌نام اخیر (۳۰ روز)</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2.5 bg-brand-charcoal text-white rounded-lg text-sm font-medium hover:bg-brand-charcoal-light transition-colors">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('admin.customers.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center" title="پاک کردن فیلترها">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Customers Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-right">
                        <th class="px-6 py-3 font-medium">مشتری</th>
                        <th class="px-6 py-3 font-medium">ایمیل</th>
                        <th class="px-6 py-3 font-medium text-center">تعداد سفارش</th>
                        <th class="px-6 py-3 font-medium text-right">مجموع خرید</th>
                        <th class="px-6 py-3 font-medium">تاریخ ثبت‌نام</th>
                        <th class="px-6 py-3 font-medium text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-brand-charcoal flex items-center justify-center text-white text-sm font-bold shrink-0">
                                    {{ mb_substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-brand-charcoal">{{ $customer->name }}</div>
                                    <div class="text-xs text-gray-400 font-num">#{{ $customer->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 font-num">{{ $customer->email }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $customer->orders_count > 0 ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $customer->orders_count > 0 ? 'bg-blue-500' : 'bg-gray-400' }}"></span>
                                {{ \App\Support\Format::digits($customer->orders_count) }} سفارش
                            </span>
                        </td>
                        <td class="px-6 py-4 font-num font-semibold text-gray-800 text-right">
                            {{ \App\Support\Format::price($customer->total_spent ?? 0) }}
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-num">
                            {{ \App\Support\Format::digits($customer->created_at->translatedFormat('Y/m/d')) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="p-2 rounded-lg text-gray-500 hover:bg-brand-red/10 hover:text-brand-red transition-colors" title="مشاهده جزئیات">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="users" class="w-7 h-7"></i>
                                </div>
                                <div class="text-sm">هیچ مشتری یافت نشد.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $customers->links() }}
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.anime) {
            anime({
                targets: '.space-y-6 > *',
                opacity: [0, 1],
                translateY: [12, 0],
                duration: 400,
                delay: anime.stagger(60),
                easing: 'easeOutCubic',
            });
        }
        window.renderIcons();
    });
</script>
@endpush
@endsection
