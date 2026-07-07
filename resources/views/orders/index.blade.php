@extends('layouts.app')

@section('title', 'سفارش‌های من')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('dashboard') }}" class="hover:text-brand-red transition">حساب کاربری</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">سفارش‌های من</span>
    </nav>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">سفارش‌های من</h1>
            <p class="text-gray-500 mt-1 text-sm">تاریخچه تمام سفارش‌های شما</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-4 py-2 rounded-lg text-sm transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>سفارش جدید</span>
        </a>
    </div>

    {{-- Orders List --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">شماره سفارش</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">تاریخ</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">مبلغ</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">وضعیت</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $order)
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
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-num font-medium text-brand-charcoal">#{{ \App\Support\Format::digits($order->id) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $order->created_at->format('Y/m/d') }}
                                </td>
                                <td class="px-6 py-4 font-num font-medium text-brand-charcoal">
                                    {{ \App\Support\Format::price($order->total_price) }} تومان
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium border {{ $status['class'] }}">{{ $status['label'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-1 text-sm text-brand-red hover:underline">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                        <span>جزئیات</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">
                <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="package-open" class="w-10 h-10 text-gray-300"></i>
                </div>
                <h3 class="text-lg font-bold text-brand-charcoal mb-2">هنوز سفارشی ندارید</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">با یک کلیک، از میان هزاران قطعه یدکی با کیفیت، آنچه نیاز دارید را انتخاب و خریداری کنید.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span>مشاهده محصولات</span>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
