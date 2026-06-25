@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- RIGHT SIDEBAR -->
        <aside class="md:w-1/4 bg-white p-4 rounded shadow hidden md:block">
            <h3 class="font-bold text-right mb-3">فیلتر محصولات</h3>

            <div class="mb-4 text-right">
                <h4 class="font-semibold">دسته‌بندی</h4>
                <ul class="mt-2 space-y-2">
                    @foreach($categories as $category)
                        <li><a href="/categories/{{ $category->id }}" class="text-gray-700">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-4 text-right">
                <h4 class="font-semibold">برند</h4>
                <ul class="mt-2 space-y-2">
                    @foreach($brands as $brand)
                        <li><a href="/brands/{{ $brand->id }}" class="text-gray-700">{{ $brand->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="mb-4 text-right">
                <h4 class="font-semibold">وضعیت موجودی</h4>
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" class="form-checkbox" />
                    <span class="mr-2">فقط کالاهای موجود</span>
                </label>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="md:flex-1">
            <div class="mb-4 flex items-center justify-between">
                <div class="text-right">۴ محصول یافت شد</div>
                <div>
                    <select class="border rounded px-2 py-1">
                        <option>جدیدترین</option>
                        <option>ارزان‌ترین</option>
                        <option>گران‌ترین</option>
                    </select>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="p-8 bg-white rounded text-center">
                    <div class="text-4xl">🔍</div>
                    <div class="mt-4">محصولی یافت نشد</div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="products-grid">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group" data-card>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <div class="relative bg-gray-100 h-52 flex items-center justify-center overflow-hidden">
                                    <span class="text-6xl">🔩</span>
                                    <span class="absolute top-3 right-3 bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-bold">{{ $product->brand->name ?? 'هوندا' }}</span>
                                    @if($product->stock > 0)
                                        <span class="absolute top-3 left-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full">موجود</span>
                                    @else
                                        <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full">ناموجود</span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4 text-right">
                                <p class="text-xs text-gray-400 mb-1">{{ $product->category->name ?? '' }}</p>
                                <h3 class="font-bold text-gray-900 text-base mb-2 line-clamp-2 leading-relaxed" style="min-height: 3rem">{{ $product->name }}</h3>
                                <div class="flex items-center justify-between mt-3">
                                    <a href="/cart/add/{{ $product->id }}" class="text-xs text-white px-3 py-2 rounded-lg font-bold transition" style="background-color: #E67E22;" data-add-to-cart>+ سبد خرید</a>
                                    <span class="text-lg font-bold" style="color: #C0392B;">{{ number_format($product->price) }} <span class="text-sm font-normal text-gray-500">تومان</span></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof anime === 'undefined') {
                return;
            }

            anime({
                targets: '#products-grid [data-card]',
                translateX: [36, 0],
                opacity: [0, 1],
                delay: anime.stagger(85, { start: 90 }),
                duration: 720,
                easing: 'easeOutCubic'
            });

            document.querySelectorAll('[data-add-to-cart]').forEach(function (button) {
                button.addEventListener('click', function () {
                    anime({
                        targets: button,
                        scale: [1, 1.1, 1],
                        duration: 380,
                        easing: 'easeOutQuad'
                    });
                });
            });
        });
    </script>
@endpush
@endsection
