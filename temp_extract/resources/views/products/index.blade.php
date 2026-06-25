@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 text-right">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-charcoal">محصولات</h1>
        <p class="text-gray-500 mt-1">قطعات یدکی اصل برای انواع موتورسیکلت</p>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar filters -->
        <aside class="md:w-1/4 bg-white p-5 rounded-2xl shadow-sm h-fit hidden md:block">
            <h3 class="font-bold text-right mb-4 flex items-center justify-end gap-2">
                فیلتر محصولات
                <i data-lucide="sliders-horizontal" class="w-4 h-4 text-brand-red"></i>
            </h3>

            <div class="mb-5 text-right">
                <h4 class="font-semibold text-sm text-gray-700 mb-2">دسته‌بندی</h4>
                <ul class="space-y-2">
                    @foreach($categories as $category)
                        <li><a href="{{ route('categories.show', $category->slug) }}" class="text-sm text-gray-600 hover:text-brand-red transition">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="text-right">
                <h4 class="font-semibold text-sm text-gray-700 mb-2">برند</h4>
                <ul class="space-y-2">
                    @foreach($brands as $brand)
                        <li><a href="{{ route('brands.show', $brand->slug) }}" class="text-sm text-gray-600 hover:text-brand-red transition">{{ $brand->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Main content -->
        <main class="md:flex-1">
            <div class="mb-5 flex items-center justify-between bg-white rounded-xl px-4 py-3 shadow-sm">
                <div class="text-sm text-gray-600">
                    <span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::digits($products->count()) }}</span>
                    محصول یافت شد
                </div>
            </div>

            @if($products->isEmpty())
                <div class="p-12 bg-white rounded-2xl text-center text-gray-500">
                    <i data-lucide="search-x" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                    محصولی یافت نشد
                </div>
            @else
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="products-grid">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;

            anime({
                targets: '#products-grid [data-card]',
                translateY: [20, 0],
                opacity: [0, 1],
                delay: anime.stagger(70, { start: 80 }),
                duration: 650,
                easing: 'easeOutCubic'
            });
        });
    </script>
@endpush
@endsection
