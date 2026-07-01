@php
    $values = $revenueByDay->pluck('value')->all();
    $labels = $revenueByDay->pluck('label')->all();
    $max = max($values) ?: 1;
    $min = 0;
    $chartW = 560;
    $chartH = 220;
    $padX = 20;
    $padY = 20;
    $stepX = ($chartW - 2 * $padX) / (count($values) - 1);
    $points = [];
    foreach ($values as $i => $v) {
        $x = $padX + $i * $stepX;
        $y = $chartH - $padY - (($v - $min) / ($max - $min ?: 1)) * ($chartH - 2 * $padY);
        $points[] = [$x, $y];
    }
    $linePath = collect($points)->map(fn($p, $i) => ($i === 0 ? 'M' : 'L') . $p[0] . ',' . $p[1])->implode(' ');
    $areaPath = $linePath . ' L' . $points[count($points)-1][0] . ',' . ($chartH - $padY) . ' L' . $points[0][0] . ',' . ($chartH - $padY) . ' Z';
    $yTicks = [0, 0.25, 0.5, 0.75, 1];
    $maxDisplay = $max >= 1000000 ? round($max / 1000000) . 'M' : round($max / 1000) . 'K';
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="font-semibold text-brand-charcoal">نمودار درآمد</h3>
            <p class="text-xs text-gray-500 mt-0.5">درآمد روزانه (تومان)</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <span class="w-2.5 h-2.5 rounded-full bg-brand-red"></span>
            <span class="text-gray-500">۷ روز گذشته</span>
        </div>
    </div>

    <div class="relative w-full" dir="ltr">
        <svg viewBox="0 0 {{ $chartW }} {{ $chartH + 30 }}" class="w-full h-auto" preserveAspectRatio="none">
            <defs>
                <linearGradient id="revArea" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#C0392B" stop-opacity="0.18" />
                    <stop offset="100%" stop-color="#C0392B" stop-opacity="0" />
                </linearGradient>
            </defs>

            {{-- Y grid lines --}}
            @foreach($yTicks as $t)
                @php $gy = $chartH - $padY - $t * ($chartH - 2 * $padY); @endphp
                <line x1="{{ $padX }}" y1="{{ $gy }}" x2="{{ $chartW - $padX }}" y2="{{ $gy }}" stroke="#E5E7EB" stroke-width="1" stroke-dasharray="3,3" />
            @endforeach

            {{-- Area + line --}}
            <path d="{{ $areaPath }}" fill="url(#revArea)" />
            <path d="{{ $linePath }}" fill="none" stroke="#C0392B" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />

            {{-- Points --}}
            @foreach($points as $i => $p)
                <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="3.5" fill="#fff" stroke="#C0392B" stroke-width="2" />
            @endforeach

            {{-- X labels --}}
            @foreach($labels as $i => $label)
                @php $lx = $padX + $i * $stepX; @endphp
                <text x="{{ $lx }}" y="{{ $chartH + 18 }}" text-anchor="middle" font-size="10" fill="#6B7280" font-family="Vazirmatn, sans-serif">{{ \App\Support\Format::digits($label) }}</text>
            @endforeach
        </svg>
    </div>
</div>
