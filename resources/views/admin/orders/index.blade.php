@extends('layouts.admin')

@section('title', 'سفارش‌ها')

@section('content')
<div class="space-y-6">

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">سفارش‌ها</h1>
            <p class="text-sm text-gray-500 mt-1">مدیریت و پیگیری سفارش‌های مشتریان</p>
        </div>

        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()" class="bg-white rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all">
                <option value="">همه وضعیت‌ها</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>ارسال شده</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>تحویل شده</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>لغو شده</option>
            </select>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-right">
                        <th class="px-6 py-3 font-medium">شماره سفارش</th>
                        <th class="px-6 py-3 font-medium">نام مشتری</th>
                        <th class="px-6 py-3 font-medium">تلفن</th>
                        <th class="px-6 py-3 font-medium text-right">مبلغ کل</th>
                        <th class="px-6 py-3 font-medium">وضعیت</th>
                        <th class="px-6 py-3 font-medium">تاریخ</th>
                        <th class="px-6 py-3 font-medium text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $statusLabels = [
                            'pending' => 'در انتظار',
                            'paid' => 'پرداخت شده',
                            'shipped' => 'ارسال شده',
                            'delivered' => 'تحویل شده',
                            'cancelled' => 'لغو شده',
                        ];
                        $badgeColors = [
                            'pending' => 'bg-amber-100 text-amber-700',
                            'paid' => 'bg-blue-100 text-blue-700',
                            'shipped' => 'bg-indigo-100 text-indigo-700',
                            'delivered' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-num font-medium text-brand-charcoal">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 font-medium text-brand-charcoal">
                                {{ $order->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-num">
                                {{ $order->phone }}
                            </td>
                            <td class="px-6 py-4 font-num font-semibold text-gray-800 text-right">
                                {{ \App\Support\Format::price($order->total_price) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 font-num">
                                {{ \App\Support\Format::digits($order->created_at->translatedFormat('Y/m/d')) }}
                                <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="p-2 rounded-lg text-gray-500 hover:bg-brand-red/10 hover:text-brand-red transition-colors" title="مشاهده جزئیات">
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
                                    <div class="text-sm">هیچ سفارشی یافت نشد.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-gray-500 font-num">
                نمایش {{ $orders->firstItem() }} تا {{ $orders->lastItem() }} از {{ $orders->total() }} سفارش
            </span>
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

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
