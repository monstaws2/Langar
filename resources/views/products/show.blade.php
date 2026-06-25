@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-500 mb-6 text-right">
        <a href="/">خانه</a> &rsaquo; <a href="{{ route('products.index') }}">محصولات</a> &rsaquo; <a href="/categories/{{ $product->category->id ?? '' }}">{{ $product->category->name ?? '' }}</a> &rsaquo; <span class="text-gray-800">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="product-show-grid">
        <!-- LEFT: Images -->
        <div class="md:col-span-1" data-product-panel>
            <div class="bg-gray-200 h-96 flex items-center justify-center">🏍️</div>
            <div class="mt-4 grid grid-cols-3 gap-2">
                <div class="h-20 bg-gray-200 flex items-center justify-center">1</div>
                <div class="h-20 bg-gray-200 flex items-center justify-center">2</div>
                <div class="h-20 bg-gray-200 flex items-center justify-center">3</div>
            </div>
        </div>

        <!-- RIGHT: Details -->
        <div class="md:col-span-2 text-right bg-white p-6 rounded shadow" data-product-panel>
            <span class="bg-[#E67E22] text-xs text-white px-2 py-1 rounded">{{ $product->brand->name ?? '' }}</span>
            <h1 class="text-2xl font-bold mt-3">{{ $product->name }}</h1>
            <p class="text-2xl text-[#C0392B] font-bold mt-2">{{ number_format($product->price) }} تومان</p>

            @if($product->stock > 0)
                <span class="text-green-600 font-semibold">موجود</span>
            @else
                <span class="text-red-600 font-semibold">ناموجود</span>
            @endif

            <hr class="my-4">

            <div class="prose text-gray-700">
                {!! $product->description ?? '<p>توضیحات محصول در اینجا قرار می‌گیرد.</p>' !!}
            </div>

            <div class="mt-4">
                <p class="font-semibold">مناسب برای: هوندا CG125، هوندا CD70</p>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <button class="px-3 py-1 bg-gray-200">-</button>
                <input type="number" value="1" class="w-16 text-center border rounded" />
                <button class="px-3 py-1 bg-gray-200">+</button>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <a href="/cart/add/{{ $product->id }}" class="block w-full text-center py-3 bg-[#C0392B] text-white rounded" data-add-to-cart>افزودن به سبد خرید</a>
                <a href="/checkout?product={{ $product->id }}" class="block w-full text-center py-3 border border-[#E67E22] text-[#E67E22] rounded">خرید مستقیم</a>
            </div>

            <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                <span>✓ اصالت کالا</span>
                <span>✓ ارسال سریع</span>
                <span>✓ مرجوعی ۷ روزه</span>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="mt-10">
        <h3 class="text-xl font-bold text-right mb-4">محصولات مرتبط</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="related-products-grid">
            @foreach($related as $p)
            <div class="bg-white rounded shadow p-4 text-right" data-card>
                    <a href="{{ route('products.show', $p->slug) }}">
                        <div class="bg-gray-200 h-40 flex items-center justify-center">🏍️</div>
                        <h4 class="mt-2 font-semibold">{{ $p->name }}</h4>
                        <p class="text-[#C0392B] font-bold">{{ number_format($p->price) }} تومان</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof anime === 'undefined') {
                return;
            }

            anime({
                targets: '#product-show-grid [data-product-panel]',
                translateX: [28, 0],
                opacity: [0, 1],
                delay: anime.stagger(130, { start: 100 }),
                duration: 780,
                easing: 'easeOutCubic'
            });

            anime({
                targets: '#related-products-grid [data-card]',
                translateY: [18, 0],
                opacity: [0, 1],
                delay: anime.stagger(90, { start: 160 }),
                duration: 680,
                easing: 'easeOutCubic'
            });

            document.querySelectorAll('[data-add-to-cart]').forEach(function (button) {
                button.addEventListener('click', function () {
                    anime({
                        targets: button,
                        scale: [1, 1.08, 1],
                        duration: 420,
                        easing: 'easeOutQuad'
                    });
                });
            });
        });
    </script>
@endpush
@endsection
