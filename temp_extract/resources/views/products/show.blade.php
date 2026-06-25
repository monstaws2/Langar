@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-6 text-right flex flex-wrap items-center justify-end gap-1">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('products.index') }}" class="hover:text-brand-red transition">محصولات</a>
        @if($product->category)
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-brand-red transition">{{ $product->category->name }}</a>
        @endif
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="product-show-grid">
        <!-- Image -->
        <div class="md:col-span-1" data-product-panel>
            <div class="bg-white rounded-2xl shadow-sm h-96 flex items-center justify-center">
                <i data-lucide="{{ $product->category->icon ?? 'package' }}" class="w-28 h-28 text-brand-charcoal/25"></i>
            </div>
        </div>

        <!-- Details -->
        <div class="md:col-span-2 text-right bg-white p-6 rounded-2xl shadow-sm" data-product-panel>
            @if($product->brand)
                <span class="bg-brand-orange text-xs text-white px-2.5 py-1 rounded-full">{{ $product->brand->name }}</span>
            @endif
            <h1 class="text-2xl font-extrabold mt-3 text-brand-charcoal">{{ $product->name }}</h1>

            <p class="text-3xl text-brand-red font-extrabold mt-3">
                <span class="font-num">{{ \App\Support\Format::price($product->price) }}</span>
                <span class="text-base font-normal text-gray-500">تومان</span>
            </p>

            <div class="mt-2">
                @if($product->stock > 0)
                    <span class="inline-flex items-center gap-1 text-green-600 font-semibold text-sm">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        موجود در انبار
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-brand-red font-semibold text-sm">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        ناموجود
                    </span>
                @endif
            </div>

            <hr class="my-5 border-gray-100">

            <div class="text-gray-700 leading-relaxed">
                {{ $product->description ?? 'توضیحات این محصول به‌زودی تکمیل می‌شود.' }}
            </div>

            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                @csrf
                <button type="submit" @disabled($product->stock < 1)
                    class="inline-flex items-center justify-center gap-2 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition disabled:opacity-50 disabled:cursor-not-allowed" data-add-to-cart>
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    افزودن به سبد خرید
                </button>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 py-3 border border-brand-orange text-brand-orange hover:bg-brand-orange hover:text-white rounded-lg transition">
                    مشاهده سبد خرید
                </a>
            </form>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-600">
                <span class="inline-flex items-center gap-1"><i data-lucide="badge-check" class="w-4 h-4 text-brand-red"></i> اصالت کالا</span>
                <span class="inline-flex items-center gap-1"><i data-lucide="truck" class="w-4 h-4 text-brand-red"></i> ارسال سریع</span>
                <span class="inline-flex items-center gap-1"><i data-lucide="rotate-ccw" class="w-4 h-4 text-brand-red"></i> مرجوعی ۷ روزه</span>
            </div>
        </div>
    </div>

    <!-- Related products -->
    @if($related->count())
    <div class="mt-12">
        <h3 class="text-xl font-extrabold text-right mb-6 text-brand-charcoal">محصولات مرتبط</h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" id="related-products-grid">
            @foreach($related as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;

            anime({
                targets: '#product-show-grid [data-product-panel]',
                translateY: [20, 0],
                opacity: [0, 1],
                delay: anime.stagger(120, { start: 90 }),
                duration: 720,
                easing: 'easeOutCubic'
            });

            anime({
                targets: '#related-products-grid [data-card]',
                translateY: [18, 0],
                opacity: [0, 1],
                delay: anime.stagger(80, { start: 140 }),
                duration: 640,
                easing: 'easeOutCubic'
            });
        });
    </script>
@endpush
@endsection
