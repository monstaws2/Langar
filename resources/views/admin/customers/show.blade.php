@extends('layouts.admin')

@section('title', 'پروفایل مشتری: ' . $customer->name)

@section('content')
<div class="space-y-6">

    {{-- Back link + Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customers.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-brand-charcoal transition-colors">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-brand-charcoal">{{ $customer->name }}</h1>
                <p class="text-sm text-gray-500 mt-1 font-num">{{ $customer->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-400 font-num">ثبت‌نام: {{ $customer->created_at->translatedFormat('j F Y') }}</span>
        </div>
    </div>

    {{-- Customer Profile Card + Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        {{-- Profile Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-brand-red to-red-700 flex items-center justify-center text-white text-2xl font-bold mb-4">
                    {{ mb_substr($customer->name, 0, 1) }}
                </div>
                <h3 class="font-bold text-brand-charcoal text-lg">{{ $customer->name }}</h3>
                <p class="text-sm text-gray-500 font-num mt-1">{{ $customer->email }}</p>
                <div class="mt-4 pt-4 border-t border-gray-100 w-full">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">وضعیت</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            فعال
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-sm mt-3">
                        <span class="text-gray-500">تاریخ ثبت‌نام</span>
                        <span class="text-brand-charcoal font-num">{{ \App\Support\Format::digits($customer->created_at->translatedFormat('Y/m/d')) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($totalOrders) }}</p>
                        <p class="text-xs text-gray-500">تعداد سفارش</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                        <i data-lucide="coins" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($totalSpent) }}</p>
                        <p class="text-xs text-gray-500">مجموع خرید (تومان)</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                        <i data-lucide="bar-chart-2" class="w-5 h-5 text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($averageOrderValue) }}</p>
                        <p class="text-xs text-gray-500">میانگین مبلغ سفارش</p>
                    </div>
                </div>
            </div>

            {{-- Orders by Status --}}
            <div class="sm:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
                <h3 class="font-semibold text-brand-charcoal mb-4 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-brand-red"></i>
                    وضعیت سفارش‌ها
                </h3>
                <div class="flex flex-wrap gap-3">
                    @php
                        $statusConfig = [
                            'pending' => ['label' => 'در انتظار', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                            'paid' => ['label' => 'پرداخت شده', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
                            'shipped' => ['label' => 'ارسال شده', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500'],
                            'delivered' => ['label' => 'تحویل شده', 'bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                            'cancelled' => ['label' => 'لغو شده', 'bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                        ];
                    @endphp
                    @foreach($statusConfig as $status => $config)
                        @php $count = $ordersByStatus[$status] ?? 0; @endphp
                        <div class="flex items-center gap-2 px-4 py-2 rounded-xl {{ $config['bg'] }}">
                            <span class="w-2 h-2 rounded-full {{ $config['dot'] }}"></span>
                            <span class="text-sm font-medium {{ $config['text'] }}">{{ $config['label'] }}</span>
                            <span class="text-sm font-bold {{ $config['text'] }} font-num">{{ \App\Support\Format::digits($count) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Orders History --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <i data-lucide="receipt" class="w-5 h-5 text-brand-red"></i>
                <h3 class="font-semibold text-brand-charcoal">تاریخچه سفارش‌ها</h3>
            </div>
            <span class="text-sm text-gray-500 font-num">{{ \App\Support\Format::digits($totalOrders) }} سفارش</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-right">
                        <th class="px-6 py-3 font-medium">شماره سفارش</th>
                        <th class="px-6 py-3 font-medium">نام</th>
                        <th class="px-6 py-3 font-medium">تلفن</th>
                        <th class="px-6 py-3 font-medium text-right">مبلغ (تومان)</th>
                        <th class="px-6 py-3 font-medium">وضعیت</th>
                        <th class="px-6 py-3 font-medium">تاریخ</th>
                        <th class="px-6 py-3 font-medium text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customer->orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-num font-medium text-brand-charcoal">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $order->name }}</td>
                        <td class="px-6 py-4 text-gray-600 font-num">{{ $order->phone }}</td>
                        <td class="px-6 py-4 font-num font-semibold text-gray-800 text-right">{{ \App\Support\Format::price($order->total_price) }}</td>
                        <td class="px-6 py-4">
                            @php
                                $badgeColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'paid' => 'bg-blue-100 text-blue-700',
                                    'shipped' => 'bg-indigo-100 text-indigo-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'در انتظار',
                                    'paid' => 'پرداخت شده',
                                    'shipped' => 'ارسال شده',
                                    'delivered' => 'تحویل شده',
                                    'cancelled' => 'لغو شده',
                                ];
                                $color = $badgeColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                                $label = $statusLabels[$order->status] ?? $order->status;
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-num">
                            {{ \App\Support\Format::digits($order->created_at->translatedFormat('Y/m/d')) }}
                            <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.orders.show', $order) }}" class="p-2 rounded-lg text-gray-500 hover:bg-brand-red/10 hover:text-brand-red transition-colors" title="مشاهده سفارش">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="receipt" class="w-7 h-7"></i>
                                </div>
                                <div class="text-sm">هنوز سفارشی ثبت نشده است.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
