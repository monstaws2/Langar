@extends('layouts.app')

@section('title', $query ? 'نتایج جستجو: ' . $query : 'جستجوی محصولات')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">جستجو</span>
        @if($query)
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <span class="text-brand-charcoal font-medium">{{ $query }}</span>
        @endif
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-brand-charcoal">جستجوی محصولات</h1>
        <p class="text-gray-500 mt-1 text-sm">قطعه مورد نظر خود را پیدا کنید</p>
    </div>

    <!-- Search form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('search.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="q" class="block text-sm font-medium text-gray-500 mb-2">کلمه کلیدی</label>
                    <div class="relative">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="q" name="q" value="{{ $query }}" placeholder="نام قطعه، برند یا مدل..." class="w-full pr-10 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm">
                    </div>
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-500 mb-2">دسته‌بندی</label>
                    <select id="category" name="category" class="w-full py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm bg-white">
                        <option value="">تمام دسته‌ها</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-500 mb-2">برند</label>
                    <select id="brand" name="brand" class="w-full py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm bg-white">
                        <option value="">تمام برندها</option>
                        @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ $brand == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-500 mb-2">حداقل قیمت (تومان)</label>
                    <input type="number" id="min_price" name="min_price" value="{{ $minPrice }}" placeholder="مثلاً 50000" class="w-full py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm font-num">
                </div>
                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-500 mb-2">حداکثر قیمت (تومان)</label>
                    <input type="number" id="max_price" name="max_price" value="{{ $maxPrice }}" placeholder="مثلاً 500000" class="w-full py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent text-sm font-num">
                </div>
                <div class="flex items-end gap-2 md:col-span-2">
                    <a href="{{ route('search.index') }}" class="flex-1 text-center px-4 py-2.5 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm">
                        پاک کردن
                    </a>
                    <button type="submit" class="flex-[2] inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-brand-red hover:bg-red-700 text-white rounded-lg transition text-sm">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        جستجو
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if($products->count() > 0)
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-brand-charcoal">
                @if($query) نتایج برای «{{ $query }}» @else همه محصولات @endif
            </h2>
            <span class="text-sm text-gray-500 font-num">{{ \App\Support\Format::digits($products->total()) }} محصول</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>

        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="search-x" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="text-xl font-bold text-brand-charcoal mb-2">محصولی یافت نشد</h2>
            <p class="text-gray-500 mb-2">با عبارت{{ $query ? ' «' . $query . '»' : '' }} محصولی پیدا نشد.</p>
            <p class="text-gray-400 text-sm mb-6">لطفاً عبارت دیگری امتحان کنید یا فیلترها را تغییر دهید.</p>
            <a href="{{ route('search.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
                <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                <span>جستجوی جدید</span>
            </a>
        </div>
    @endif
</div>
@endsection
