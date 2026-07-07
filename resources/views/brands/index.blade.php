@extends('layouts.app')

@section('title', 'برندها')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">برندها</span>
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-brand-charcoal">برندهای معتبر</h1>
        <p class="text-gray-500 mt-1 text-sm">قطعات یدکی اصلی از بهترین برندهای موتورسیکلت</p>
    </div>

    @if(count($brands) > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($brands as $brand)
        <a href="{{ route('brands.show', $brand->slug) }}" class="bg-white rounded-xl border border-gray-200 hover:border-brand-red/30 hover:shadow-lg transition overflow-hidden group">
            <div class="bg-gray-50 h-32 flex items-center justify-center">
                <i data-lucide="bike" class="w-12 h-12 text-gray-300 group-hover:text-brand-red transition"></i>
            </div>
            <div class="p-4 text-center">
                <h3 class="font-bold text-brand-charcoal">{{ $brand->name }}</h3>
                <span class="font-num text-xs text-gray-400 uppercase">{{ $brand->slug }}</span>
                <div class="mt-2 inline-flex items-center gap-1 text-xs text-brand-red">
                    <span class="font-num">{{ \App\Support\Format::digits($brand->products()->where('is_active', true)->count()) }}</span>
                    <span>محصول</span>
                    <i data-lucide="chevron-left" class="w-3 h-3"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="store" class="w-10 h-10 text-gray-300"></i>
        </div>
        <h2 class="text-xl font-bold text-brand-charcoal mb-2">برندی موجود نیست</h2>
        <p class="text-gray-500">لطفاً بعداً دوباره بررسی کنید.</p>
    </div>
    @endif
</div>
@endsection
