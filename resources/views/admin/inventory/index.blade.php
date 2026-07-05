@extends('layouts.admin')

@section('title', 'مدیریت انبار')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">انبار</h1>
            <p class="text-sm text-gray-500 mt-1">مدیریت موجودی و تنظیمات انبار</p>
        </div>
    </div>

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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Inventory Adjustment Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i data-lucide="sliders" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal">تنظیم موجودی</h3>
                    <p class="text-xs text-gray-500">افزایش یا کاهش موجودی محصول</p>
                </div>
            </div>

            <form action="{{ route('admin.inventory.adjust') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">محصول</label>
                    <select name="product_id" id="product_id" class="w-full bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                        <option value="">انتخاب محصول...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ \App\Support\Format::digits($product->stock) }} عدد)</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="change_amount" class="block text-sm font-medium text-gray-700 mb-1">مقدار تغییر</label>
                        <input type="number" name="change_amount" id="change_amount" placeholder="+5 یا -3" class="w-full bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num">
                        @error('change_amount')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">دلیل</label>
                        <select name="reason" id="reason" class="w-full bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                            <option value="purchase">خرید</option>
                            <option value="sale">فروش</option>
                            <option value="adjustment">تنظیم دستی</option>
                            <option value="damage">ضایعات</option>
                            <option value="return">برگشت</option>
                            <option value="correction">تصحیح</option>
                        </select>
                        @error('reason')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1">یادداشت (اختیاری)</label>
                    <textarea name="note" id="note" rows="3" class="w-full bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all"></textarea>
                </div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>اعمال تغییر</span>
                </button>
            </form>
        </div>

        {{-- Inventory Logs --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <i data-lucide="history" class="w-5 h-5 text-purple-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal">تاریخچه تغییرات</h3>
                    <p class="text-xs text-gray-500">آخرین تغییرات موجودی</p>
                </div>
            </div>

            <div class="space-y-3 max-h-[420px] overflow-y-auto no-scrollbar">
                @if($inventoryLogs->isEmpty())
                    <div class="text-center py-8 text-gray-400">
                        <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-3 text-gray-300"></i>
                        <p class="text-sm">هیچ تغییری ثبت نشده است.</p>
                    </div>
                @else
                    @foreach($inventoryLogs->take(15) as $log)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="w-8 h-8 rounded-lg {{ $log->change_amount > 0 ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center shrink-0">
                                <i data-lucide="{{ $log->change_amount > 0 ? 'plus' : 'minus' }}" class="w-4 h-4 {{ $log->change_amount > 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-brand-charcoal truncate">{{ $log->product?->name ?? '—' }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs font-num font-bold {{ $log->change_amount > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $log->change_amount > 0 ? '+' : '' }}{{ \App\Support\Format::digits($log->change_amount) }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $log->reason }}</span>
                                </div>
                                @if($log->note)
                                    <p class="text-xs text-gray-400 mt-1">{{ $log->note }}</p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-400 shrink-0 font-num">{{ $log->created_at->format('Y/m/d') }}</span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Low Stock Alert --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-brand-orange"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal">هشدار موجودی کم</h3>
                    <p class="text-xs text-gray-500">محصولات با موجودی کمتر از ۵ عدد</p>
                </div>
            </div>

            @if($lowStockProducts->isEmpty())
                <div class="text-center py-8">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>
                    </div>
                    <p class="text-sm text-gray-500">همه محصولات موجودی کافی دارند.</p>
                </div>
            @else
                <div class="space-y-3 max-h-[420px] overflow-y-auto no-scrollbar">
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
