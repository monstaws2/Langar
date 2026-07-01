<div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <i data-lucide="receipt" class="w-5 h-5 text-brand-red"></i>
            <h3 class="font-semibold text-brand-charcoal">سفارش‌های اخیر</h3>
        </div>
        <a href="#" class="text-sm font-medium text-brand-red hover:text-brand-red-dark transition-colors">مشاهده همه سفارش‌ها</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-right">
                    <th class="px-6 py-3 font-medium">شماره سفارش</th>
                    <th class="px-6 py-3 font-medium">نام مشتری</th>
                    <th class="px-6 py-3 font-medium">محصول</th>
                    <th class="px-6 py-3 font-medium">مبلغ (تومان)</th>
                    <th class="px-6 py-3 font-medium">وضعیت</th>
                    <th class="px-6 py-3 font-medium">تاریخ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-num font-medium text-brand-charcoal">{{ \App\Support\Format::digits($order->order_number) }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $order->customer_name }}</td>
                    <td class="px-6 py-4 text-gray-600 max-w-[180px] truncate">{{ $order->product_name }}</td>
                    <td class="px-6 py-4 font-num font-medium text-gray-800">{{ \App\Support\Format::price($order->amount) }}</td>
                    <td class="px-6 py-4">
                        @php
                            $badgeColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'shipped' => 'bg-blue-100 text-blue-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $color = $badgeColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">{{ $order->statusLabel() }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 font-num">{{ \App\Support\Format::digits($order->ordered_at->translatedFormat('Y/m/d')) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">سفارشی ثبت نشده است.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
