@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">جستجو</h1>
        <p class="text-gray-600 mt-2">محصولات مورد نظر خود را پیدا کنید</p>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('search.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Query -->
                <div>
                    <label for="q" class="block text-gray-700 font-semibold mb-2">جستجو</label>
                    <input type="text" id="q" name="q" value="{{ $query }}" placeholder="نام محصول را وارد کنید..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600">
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-gray-700 font-semibold mb-2">دسته‌بندی</label>
                    <select id="category" name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600">
                        <option value="">تمام دسته‌ها</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Brand Filter -->
                <div>
                    <label for="brand" class="block text-gray-700 font-semibold mb-2">برند</label>
                    <select id="brand" name="brand" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600">
                        <option value="">تمام برندها</option>
                        @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ $brand == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('search.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    پاک کردن فیلترها
                </a>
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                    جستجو
                </button>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if(count($products) > 0)
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            نتایج جستجو
            @if($query)
            برای "{{ $query }}"
            @endif
            ({{ count($products) }} محصول)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <!-- Product Image -->
                <div class="bg-gray-200 h-48 flex items-center justify-center">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path>
                    </svg>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $product->category->name ?? 'بدون دسته' }}</p>
                    <p class="text-sm text-orange-600 mt-1">برند: {{ $product->brand->name ?? 'نامشخص' }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-red-600">{{ number_format($product->price) }} تومان</span>
                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">موجود</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <h2 class="text-2xl font-semibold text-gray-900 mt-4">نتیجه‌ای یافت نشد</h2>
        <p class="text-gray-600 mt-2">لطفاً فیلترهای خود را تغییر دهید و دوباره سعی کنید</p>
    </div>
    @endif
</div>
@endsection
