@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('brands.index') }}" class="text-red-600 hover:text-red-700 font-semibold mb-4 inline-block">← بازگشت به برندها</a>
        
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex items-center gap-6">
                <!-- Brand Logo -->
                <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg p-6 w-48 h-48 flex items-center justify-center flex-shrink-0">
                    @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain">
                    @else
                    <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5m-15-4h12m-12 3h12m-12 3h12m-12 3h6" stroke="currentColor" stroke-width="1.5" fill="none"></path>
                    </svg>
                    @endif
                </div>

                <!-- Brand Info -->
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">{{ $brand->name }}</h1>
                    @if($brand->description)
                    <p class="text-gray-600 mt-4 text-lg">{{ $brand->description }}</p>
                    @endif
                    <div class="mt-6 flex gap-4">
                        <div class="bg-red-100 rounded-lg p-3">
                            <p class="text-sm text-gray-600">تعداد محصولات</p>
                            <p class="text-2xl font-bold text-red-600">{{ count($products) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6">محصولات {{ $brand->name }}</h2>

        @if(count($products) > 0)
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
                    
                    <!-- SKU -->
                    @if($product->sku)
                    <p class="text-xs text-gray-500 mt-2">کد: {{ $product->sku }}</p>
                    @endif

                    <!-- Price and Stock -->
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-red-600">{{ number_format($product->price) }} تومان</span>
                        @if($product->stock > 0)
                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">موجود</span>
                        @else
                        <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded">ناموجود</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-900 mt-4">محصولی در این برند موجود نیست</h2>
            <p class="text-gray-600 mt-2">لطفاً برند دیگری را انتخاب کنید</p>
            <a href="{{ route('brands.index') }}" class="inline-block mt-6 px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                بازگشت به برندها
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
