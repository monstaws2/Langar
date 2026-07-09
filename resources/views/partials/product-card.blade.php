{{-- Expects: $product (with brand & category loaded) --}}
<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 overflow-hidden flex flex-col group" data-card>
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="relative bg-brand-offwhite h-44 flex items-center justify-center overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
                <i data-lucide="{{ $product->category->icon ?? 'package' }}" class="w-16 h-16 text-brand-charcoal/30 group-hover:scale-110 transition-transform duration-300"></i>
            @endif
            @if($product->brand)
                <span class="absolute top-3 right-3 bg-brand-orange text-white text-[11px] px-2 py-1 rounded-full font-bold">{{ $product->brand->name }}</span>
            @endif
            @if($product->stock > 0)
                <span class="absolute top-3 left-3 bg-green-600 text-white text-[11px] px-2 py-1 rounded-full">موجود</span>
            @else
                <span class="absolute top-3 left-3 bg-brand-red text-white text-[11px] px-2 py-1 rounded-full">ناموجود</span>
            @endif
        </div>
    </a>
    <div class="p-4 flex flex-col flex-1 text-right">
        <p class="text-xs text-gray-400 mb-1">{{ $product->category->name ?? '' }}</p>
        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3 class="font-bold text-brand-charcoal text-sm leading-relaxed line-clamp-2 hover:text-brand-red transition" style="min-height: 2.75rem">{{ $product->name }}</h3>
        </a>
        <div class="mt-3 flex items-center justify-between gap-2">
            <span class="text-lg font-bold text-brand-red whitespace-nowrap">
                <span class="font-num">{{ \App\Support\Format::price($product->price) }}</span>
                <span class="text-xs font-normal text-gray-500">تومان</span>
            </span>
        </div>
        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3">
            @csrf
            @if($product->stock > 0)
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 bg-brand-orange hover:bg-amber-600 active:scale-95 text-white rounded-lg text-sm font-bold transition-all duration-150"
                    data-add-to-cart>
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    افزودن به سبد
                </button>
            @else
                <button type="button" disabled
                    class="w-full inline-flex items-center justify-center gap-2 py-2.5 bg-gray-200 text-gray-400 rounded-lg text-sm font-bold cursor-not-allowed">
                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                    ناموجود
                </button>
            @endif
        </form>
    </div>
</div>
