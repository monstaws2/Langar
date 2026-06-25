@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">تمام برندها</h1>
        <p class="text-gray-600 mt-2">برندهای معتبر و معروف موتورسازی</p>
    </div>

    @if(count($brands) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($brands as $brand)
        <a href="{{ route('brands.show', $brand->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
            <!-- Brand Logo -->
            <div class="bg-gradient-to-br from-gray-100 to-gray-200 h-40 flex items-center justify-center p-4">
                @if($brand->logo)
                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain">
                @else
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H3.75A2.25 2.25 0 001.5 3.75v12.5A2.25 2.25 0 003.75 18.5h12.5a2.25 2.25 0 002.25-2.25V9.5m-15-4h12m-12 3h12m-12 3h12m-12 3h6" stroke="currentColor" stroke-width="1.5" fill="none"></path>
                    </svg>
                    <p class="text-sm text-gray-600">بدون لوگو</p>
                </div>
                @endif
            </div>

            <!-- Brand Info -->
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $brand->name }}</h3>
                @if($brand->description)
                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $brand->description }}</p>
                @endif
                <div class="mt-4 flex justify-between items-center">
                    <span class="text-sm text-orange-600 font-semibold">مشاهده محصولات →</span>
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
        <h2 class="text-2xl font-semibold text-gray-900 mt-4">برندی موجود نیست</h2>
        <p class="text-gray-600 mt-2">لطفاً بعداً دوباره بررسی کنید</p>
    </div>
    @endif
</div>
@endsection
