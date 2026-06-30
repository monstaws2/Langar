<div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-brand-orange"></i>
            </div>
            <div>
                <h3 class="font-semibold text-brand-charcoal">هشدار موجودی کم</h3>
                <p class="text-xs text-gray-500 mt-0.5">محصولات با موجودی کمتر از ۵ عدد</p>
            </div>
        </div>
        <a href="#" class="text-sm font-medium text-brand-red hover:text-brand-red-dark transition-colors">مشاهده همه</a>
    </div>

    @if($lowStockProducts->isEmpty())
        <div class="text-center py-8 text-gray-400 text-sm">همه محصولات موجودی کافی دارند.</div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($lowStockProducts as $product)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <div class="w-12 h-12 rounded-lg bg-brand-charcoal flex items-center justify-center shrink-0">
                        <i data-lucide="package" class="w-6 h-6 text-gray-300"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-medium text-brand-charcoal truncate">{{ $product->name }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $product->category?->name ?? '—' }}</div>
                    </div>
                    <div class="text-left shrink-0">
                        <div class="text-xs text-gray-400">موجودی</div>
                        <div class="text-sm font-bold font-num text-brand-red">{{ \App\Support\Format::digits($product->stock) }} عدد</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
