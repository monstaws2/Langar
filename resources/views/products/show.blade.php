@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('products.index') }}" class="hover:text-brand-red transition">محصولات</a>
        @if($product->category)
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="hover:text-brand-red transition">{{ $product->category->name }}</a>
        @endif
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="product-show-grid">
        <!-- Image -->
        <div class="md:col-span-1" data-product-panel>
            <div class="bg-white rounded-2xl border border-gray-200 h-80 sm:h-96 flex items-center justify-center relative overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="flex flex-col items-center text-gray-300">
                        <i data-lucide="{{ $product->category->icon ?? 'package' }}" class="w-24 h-24 sm:w-28 sm:h-28"></i>
                        <span class="text-xs mt-2">{{ $product->category->name ?? 'محصول' }}</span>
                    </div>
                @endif

                @if($product->stock > 0 && $product->stock <= 5)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg">تنها {{ \App\Support\Format::digits($product->stock) }} عدد باقی‌مانده</span>
                @elseif($product->stock < 1)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-gray-800/80 text-white text-xs font-bold rounded-lg">ناموجود</span>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-gray-200" data-product-panel>
            <div class="flex items-center gap-2 mb-3">
                @if($product->brand)
                    <span class="bg-brand-red/10 text-brand-red text-xs px-2.5 py-1 rounded-full font-medium">{{ $product->brand->name }}</span>
                @endif
                @if($product->category)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">{{ $product->category->name }}</span>
                @endif
            </div>

            <h1 class="text-2xl font-extrabold text-brand-charcoal leading-tight">{{ $product->name }}</h1>

            <div class="flex items-center gap-4 mt-4">
                <p class="text-3xl text-brand-red font-extrabold font-num">
                    {{ \App\Support\Format::price($product->price) }}
                    <span class="text-base font-normal text-gray-400">تومان</span>
                </p>
            </div>

            <div class="mt-3 flex items-center gap-4">
                @if($product->stock > 0)
                    <span class="inline-flex items-center gap-1.5 text-green-600 font-medium text-sm bg-green-50 px-3 py-1.5 rounded-lg">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        موجود در انبار ({{ \App\Support\Format::digits($product->stock) }} عدد)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-red-600 font-medium text-sm bg-red-50 px-3 py-1.5 rounded-lg">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        ناموجود
                    </span>
                @endif

                <span class="inline-flex items-center gap-1.5 text-blue-600 font-medium text-sm bg-blue-50 px-3 py-1.5 rounded-lg">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    ضمانت اصالت
                </span>
            </div>

            <hr class="my-6 border-gray-100">

            <div class="text-gray-600 leading-relaxed text-sm">
                {{ $product->description ?: 'توضیحات این محصول به‌زودی تکمیل می‌شود.' }}
            </div>

            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6 flex flex-col sm:flex-row gap-3">
                @csrf
                <button type="submit" @disabled($product->stock < 1)
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3.5 bg-brand-red hover:bg-red-700 text-white rounded-xl font-bold transition disabled:opacity-40 disabled:cursor-not-allowed">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    @if($product->stock > 0)
                        افزودن به سبد خرید
                    @else
                        در حال حاضر ناموجود
                    @endif
                </button>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 py-3.5 border-2 border-gray-200 text-gray-600 hover:border-brand-red hover:text-brand-red rounded-xl transition font-medium">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    مشاهده سبد خرید
                </a>
            </form>

            <div class="mt-6 grid grid-cols-3 gap-3">
                <div class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="badge-check" class="w-6 h-6 text-brand-red"></i>
                    <span class="text-xs text-gray-600 font-medium">ضمانت اصالت</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="truck" class="w-6 h-6 text-brand-red"></i>
                    <span class="text-xs text-gray-600 font-medium">ارسال سریع</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="rotate-ccw" class="w-6 h-6 text-brand-red"></i>
                    <span class="text-xs text-gray-600 font-medium">مرجوعی ۷ روزه</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Related products -->
    @if($related->count())
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-extrabold text-brand-charcoal">محصولات مرتبط</h3>
            <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-sm text-brand-red hover:underline flex items-center gap-1">
                مشاهده همه
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4" id="related-products-grid">
            @foreach($related as $rProduct)
                @include('partials.product-card', ['product' => $rProduct])
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
