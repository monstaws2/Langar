@extends('layouts.app')

@section('title', 'محصولات')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">محصولات</span>
        @if(request('category'))
            @php $cat = $categories->firstWhere('id', request('category')); @endphp
            @if($cat)
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                <span class="text-brand-charcoal font-medium">{{ $cat->name }}</span>
            @endif
        @endif
        @if(request('brand'))
            @php $br = $brands->firstWhere('id', request('brand')); @endphp
            @if($br)
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                <span class="text-brand-charcoal font-medium">{{ $br->name }}</span>
            @endif
        @endif
    </nav>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">محصولات</h1>
            <p class="text-gray-500 mt-1 text-sm">{{ \App\Support\Format::digits($products->total()) }} محصول یافت شد</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Sort --}}
            <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
                @foreach(request()->except('sort', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <select name="sort" onchange="this.form.submit()" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red">
                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>جدیدترین</option>
                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>قیمت: کم به زیاد</option>
                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>قیمت: زیاد به کم</option>
                    <option value="name" {{ $sort == 'name' ? 'selected' : '' }}>نام</option>
                </select>
            </form>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Filters Sidebar --}}
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 p-5 sticky top-24">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-brand-charcoal flex items-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i>
                        فیلترها
                    </h3>
                    @if(request('category') || request('brand'))
                        <a href="{{ route('products.index') }}" class="text-xs text-brand-red hover:underline">حذف فیلترها</a>
                    @endif
                </div>

                {{-- Categories --}}
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">دسته‌بندی</h4>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $category->id])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ request('category') == $category->id ? 'bg-brand-red text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span>{{ $category->name }}</span>
                                <span class="font-num text-xs {{ request('category') == $category->id ? 'text-white/70' : 'text-gray-400' }}">{{ \App\Support\Format::digits($category->products()->where('is_active', true)->count()) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Brands --}}
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">برند</h4>
                    <div class="space-y-2">
                        @foreach($brands as $brand)
                            <a href="{{ route('products.index', array_merge(request()->except('brand', 'page'), ['brand' => $brand->id])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition {{ request('brand') == $brand->id ? 'bg-brand-red text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span>{{ $brand->name }}</span>
                                <span class="font-num text-xs {{ request('brand') == $brand->id ? 'text-white/70' : 'text-gray-400' }}">{{ \App\Support\Format::digits($brand->products()->where('is_active', true)->count()) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="search-x" class="w-10 h-10 text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-brand-charcoal mb-2">محصولی یافت نشد</h3>
                    <p class="text-gray-500 mb-6">با فیلترهای انتخابی شما محصولی مطابقت ندارد.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
                        <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                        <span>حذف فیلترها</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
