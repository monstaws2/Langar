@extends('layouts.admin')

@section('title', 'گزارش‌ها و آمار')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">گزارش‌ها</h1>
            <p class="text-sm text-gray-500 mt-1">آمار و تحلیل فروشگاه لنگر موتور</p>
        </div>
        <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex items-center gap-2">
            <select name="period" onchange="this.form.submit()" class="bg-white rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all">
                <option value="7" {{ $period === '7' ? 'selected' : '' }}>۷ روز گذشته</option>
                <option value="30" {{ $period === '30' ? 'selected' : '' }}>۳۰ روز گذشته</option>
                <option value="90" {{ $period === '90' ? 'selected' : '' }}>۹۰ روز گذشته</option>
                <option value="365" {{ $period === '365' ? 'selected' : '' }}>یک سال گذشته</option>
            </select>
        </form>
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i data-lucide="shopping-cart" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($totalOrders) }}</p>
                    <p class="text-xs text-gray-500">کل سفارش‌ها</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50 flex items-center gap-1 text-xs">
                <span class="text-gray-400">در این دوره:</span>
                <span class="font-num font-medium text-blue-600">+{{ \App\Support\Format::digits($periodOrders) }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                    <i data-lucide="coins" class="w-5 h-5 text-green-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($totalRevenue) }}</p>
                    <p class="text-xs text-gray-500">درآمد کل (تومان)</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50 flex items-center gap-1 text-xs">
                <span class="text-gray-400">در این دوره:</span>
                <span class="font-num font-medium text-green-600">+{{ \App\Support\Format::price($periodRevenue) }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <i data-lucide="users" class="w-5 h-5 text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($totalCustomers) }}</p>
                    <p class="text-xs text-gray-500">مشتریان</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50 flex items-center gap-1 text-xs">
                <span class="text-gray-400">جدید در این دوره:</span>
                <span class="font-num font-medium text-indigo-600">+{{ \App\Support\Format::digits($periodCustomers) }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <i data-lucide="package" class="w-5 h-5 text-amber-600"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-brand-charcoal font-num">{{ \App\Support\Format::digits($totalProducts) }}</p>
                    <p class="text-xs text-gray-500">محصولات فعال</p>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-50 flex items-center gap-1 text-xs">
                <span class="text-gray-400">رشد ماهانه:</span>
                <span class="font-num font-medium {{ $monthlyGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $monthlyGrowth >= 0 ? '+' : '' }}{{ \App\Support\Format::digits($monthlyGrowth) }}%
                </span>
            </div>
        </div>
    </div>

    {{-- Daily Revenue Chart --}}
    @php
        $chartValues = $dailyRevenue;
        $chartLabels = $dailyLabels;
        $maxVal = max($chartValues) ?: 1;
        $chartW = 800;
        $chartH = 260;
        $padX = 40;
        $padY = 30;
        $stepX = count($chartValues) > 1 ? ($chartW - 2 * $padX) / (count($chartValues) - 1) : 0;
        $points = [];
        foreach ($chartValues as $i => $v) {
            $x = count($chartValues) > 1 ? $padX + $i * $stepX : $chartW / 2;
            $y = $chartH - $padY - (($v) / ($maxVal ?: 1)) * ($chartH - 2 * $padY);
            $points[] = [$x, $y];
        }
        if (count($points) > 0) {
            $linePath = collect($points)->map(fn($p, $i) => ($i === 0 ? 'M' : 'L') . $p[0] . ',' . $p[1])->implode(' ');
            $areaPath = $linePath . ' L' . $points[count($points)-1][0] . ',' . ($chartH - $padY) . ' L' . $points[0][0] . ',' . ($chartH - $padY) . ' Z';
        } else {
            $linePath = '';
            $areaPath = '';
        }
        $yTicks = [0, 0.25, 0.5, 0.75, 1.0];
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Revenue Chart --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-semibold text-brand-charcoal">نمودار درآمد روزانه</h3>
                    <p class="text-xs text-gray-500 mt-0.5 font-num">{{ count($chartLabels) }} روز گذشته</p>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-red"></span>
                    <span class="text-gray-500">درآمد (تومان)</span>
                </div>
            </div>
            <div class="relative w-full" dir="ltr">
                <svg viewBox="0 0 {{ $chartW }} {{ $chartH + 35 }}" class="w-full h-auto" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <linearGradient id="revArea" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#C0392B" stop-opacity="0.18" />
                            <stop offset="100%" stop-color="#C0392B" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    @foreach($yTicks as $t)
                        @php $gy = $chartH - $padY - $t * ($chartH - 2 * $padY); @endphp
                        <line x1="{{ $padX }}" y1="{{ $gy }}" x2="{{ $chartW - $padX }}" y2="{{ $gy }}" stroke="#E5E7EB" stroke-width="1" stroke-dasharray="3,3" />
                        @php $tickVal = round($t * $maxVal); @endphp
                        <text x="{{ $padX - 5 }}" y="{{ $gy + 3 }}" text-anchor="end" font-size="9" fill="#9CA3AF" font-family="Inter, sans-serif">{{ \App\Support\Format::digits(number_format($tickVal)) }}</text>
                    @endforeach
                    @if($linePath)
                        <path d="{{ $areaPath }}" fill="url(#revArea)" />
                        <path d="{{ $linePath }}" fill="none" stroke="#C0392B" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                        @foreach($points as $i => $p)
                            <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="3.5" fill="#fff" stroke="#C0392B" stroke-width="2" />
                        @endforeach
                    @endif
                    @foreach($chartLabels as $i => $label)
                        @php
                            $lx = count($chartValues) > 1 ? $padX + $i * $stepX : $chartW / 2;
                            $showLabel = count($chartLabels) <= 15 || $i % 2 === 0;
                        @endphp
                        @if($showLabel)
                            <text x="{{ $lx }}" y="{{ $chartH + 18 }}" text-anchor="middle" font-size="9" fill="#6B7280" font-family="Vazirmatn, sans-serif">{{ \App\Support\Format::digits($label) }}</text>
                        @endif
                    @endforeach
                </svg>
            </div>
        </div>

        {{-- Order Status Distribution --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <h3 class="font-semibold text-brand-charcoal mb-4">توزیع وضعیت سفارش‌ها</h3>
            <div class="space-y-3">
                @php
                    $statusConfig = [
                        'pending' => ['label' => 'در انتظار', 'bg' => 'bg-amber-500', 'light' => 'bg-amber-100'],
                        'paid' => ['label' => 'پرداخت شده', 'bg' => 'bg-blue-500', 'light' => 'bg-blue-100'],
                        'shipped' => ['label' => 'ارسال شده', 'bg' => 'bg-indigo-500', 'light' => 'bg-indigo-100'],
                        'delivered' => ['label' => 'تحویل شده', 'bg' => 'bg-green-500', 'light' => 'bg-green-100'],
                        'cancelled' => ['label' => 'لغو شده', 'bg' => 'bg-red-500', 'light' => 'bg-red-100'],
                    ];
                    $maxStatusCount = max($ordersByStatus) ?: 1;
                @endphp
                @foreach($statusConfig as $status => $config)
                    @php $count = $ordersByStatus[$status] ?? 0; @endphp
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-600">{{ $config['label'] }}</span>
                            <span class="text-sm font-bold font-num text-brand-charcoal">{{ \App\Support\Format::digits($count) }}</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full {{ $config['bg'] }} transition-all duration-500" style="width: {{ ($count / $maxStatusCount) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Monthly Growth Indicator --}}
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">رشد نسبت به ماه قبل</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $monthlyGrowth >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i data-lucide="{{ $monthlyGrowth >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3"></i>
                        <span class="font-num">{{ $monthlyGrowth >= 0 ? '+' : '' }}{{ \App\Support\Format::digits($monthlyGrowth) }}%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Monthly Sales Chart + Top Products --}}
    @php
        $mValues = $monthlySalesData;
        $mLabels = $monthlyLabels;
        $mMax = max($mValues) ?: 1;
        $mChartW = 560;
        $mChartH = 200;
        $mPadX = 20;
        $mPadY = 20;
        $mStepX = count($mValues) > 1 ? ($mChartW - 2 * $mPadX) / (count($mValues) - 1) : 0;
        $mPoints = [];
        foreach ($mValues as $i => $v) {
            $x = count($mValues) > 1 ? $mPadX + $i * $mStepX : $mChartW / 2;
            $y = $mChartH - $mPadY - (($v) / ($mMax ?: 1)) * ($mChartH - 2 * $mPadY);
            $mPoints[] = [$x, $y];
        }
        if (count($mPoints) > 0) {
            $mLinePath = collect($mPoints)->map(fn($p, $i) => ($i === 0 ? 'M' : 'L') . $p[0] . ',' . $p[1])->implode(' ');
            $mAreaPath = $mLinePath . ' L' . $mPoints[count($mPoints)-1][0] . ',' . ($mChartH - $mPadY) . ' L' . $mPoints[0][0] . ',' . ($mChartH - $mPadY) . ' Z';
        } else {
            $mLinePath = '';
            $mAreaPath = '';
        }
    @endphp

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Monthly Sales Chart --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-semibold text-brand-charcoal">فروش ماهانه</h3>
                    <p class="text-xs text-gray-500 mt-0.5">۶ ماه گذشته</p>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-red"></span>
                    <span class="text-gray-500">فروش (تومان)</span>
                </div>
            </div>
            <div class="relative w-full" dir="ltr">
                <svg viewBox="0 0 {{ $mChartW }} {{ $mChartH + 30 }}" class="w-full h-auto" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <linearGradient id="monthArea" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#C0392B" stop-opacity="0.15" />
                            <stop offset="100%" stop-color="#C0392B" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    @foreach([0, 0.5, 1.0] as $t)
                        @php $gy = $mChartH - $mPadY - $t * ($mChartH - 2 * $mPadY); @endphp
                        <line x1="{{ $mPadX }}" y1="{{ $gy }}" x2="{{ $mChartW - $mPadX }}" y2="{{ $gy }}" stroke="#E5E7EB" stroke-width="1" stroke-dasharray="3,3" />
                    @endforeach
                    @if($mLinePath)
                        <path d="{{ $mAreaPath }}" fill="url(#monthArea)" />
                        <path d="{{ $mLinePath }}" fill="none" stroke="#C0392B" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                        @foreach($mPoints as $i => $p)
                            <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="4" fill="#fff" stroke="#C0392B" stroke-width="2" />
                        @endforeach
                    @endif
                    @foreach($mLabels as $i => $label)
                        @php $lx = count($mValues) > 1 ? $mPadX + $i * $mStepX : $mChartW / 2; @endphp
                        <text x="{{ $lx }}" y="{{ $mChartH + 18 }}" text-anchor="middle" font-size="10" fill="#6B7280" font-family="Vazirmatn, sans-serif">{{ \App\Support\Format::digits($label) }}</text>
                    @endforeach
                </svg>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <h3 class="font-semibold text-brand-charcoal mb-4 flex items-center gap-2">
                <i data-lucide="trophy" class="w-4 h-4 text-amber-500"></i>
                محصولات پرفروش
            </h3>
            <div class="space-y-3">
                @forelse($topProducts as $index => $product)
                    <div class="flex items-center gap-3 p-3 rounded-xl {{ $index === 0 ? 'bg-amber-50 border border-amber-100' : 'bg-gray-50 border border-gray-100' }}">
                        <div class="w-7 h-7 rounded-lg {{ $index < 3 ? 'bg-brand-charcoal text-white' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center text-xs font-bold shrink-0 font-num">
                            {{ $index + 1 }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-brand-charcoal truncate">{{ $product->product_name }}</p>
                            <p class="text-xs text-gray-500 font-num">{{ \App\Support\Format::digits($product->total_qty) }} فروش</p>
                        </div>
                        <div class="text-left shrink-0">
                            <p class="text-sm font-semibold text-brand-charcoal font-num">{{ \App\Support\Format::price($product->total_revenue) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i data-lucide="package" class="w-8 h-8 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-sm">هیچ داده‌ای برای نمایش وجود ندارد.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Activity + Low Stock --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Recent Activity --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <h3 class="font-semibold text-brand-charcoal mb-4 flex items-center gap-2">
                <i data-lucide="activity" class="w-4 h-4 text-brand-red"></i>
                فعالیت‌های اخیر
            </h3>
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $activity['icon'] }}" class="w-4 h-4 {{ $activity['color'] }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-brand-charcoal">{{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $activity['description'] }}</p>
                        </div>
                        <span class="text-xs text-gray-400 shrink-0">{{ $activity['time'] }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i data-lucide="clock" class="w-8 h-8 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-sm">هیچ فعالیت اخیری ثبت نشده است.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Low Stock Alert --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <h3 class="font-semibold text-brand-charcoal mb-4 flex items-center gap-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-brand-orange"></i>
                هشدار موجودی کم
            </h3>
            @if($lowStockProducts->isEmpty())
                <div class="text-center py-8">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                    </div>
                    <p class="text-sm text-gray-500">همه محصولات موجودی کافی دارند.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-orange-50/50 border border-orange-100">
                            <div class="w-10 h-10 rounded-lg bg-brand-charcoal flex items-center justify-center shrink-0">
                                <i data-lucide="package" class="w-5 h-5 text-gray-300"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-brand-charcoal truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->category?->name ?? '—' }}</p>
                            </div>
                            <div class="text-left shrink-0">
                                <p class="text-xs text-gray-400">موجودی</p>
                                <p class="text-sm font-bold font-num text-brand-red">{{ \App\Support\Format::digits($product->stock) }} عدد</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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
