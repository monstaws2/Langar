@extends('layouts.app')

@section('title', $brand->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('brands.index') }}" class="hover:text-brand-red transition">برندها</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">{{ $brand->name }}</span>
    </nav>

    <!-- Brand header -->
    <div class="bg-brand-charcoal rounded-xl p-6 sm:p-8 mb-8">
        <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-right">
            <span class="w-16 h-16 rounded-xl bg-brand-red flex items-center justify-center shrink-0">
                <i data-lucide="bike" class="w-8 h-8 text-white"></i>
            </span>
            <div>
                <h1 class="text-2xl font-extrabold text-white">{{ $brand->name }}</h1>
                <div class="flex items-center gap-4 mt-2 justify-center sm:justify-start">
                    <span class="text-sm text-gray-400 font-num uppercase">{{ $brand->slug }}</span>
                    <span class="inline-flex items-center gap-1.5 bg-white/10 text-white rounded-lg px-3 py-1 text-xs">
                        <i data-lucide="package" class="w-3 h-3"></i>
                        <span class="font-num">{{ \App\Support\Format::digits(count($products)) }}</span> محصول
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products -->
    @if(count($products) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($products as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl border border-gray-200 py-16 text-center">
        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="package-open" class="w-10 h-10 text-gray-300"></i>
        </div>
        <h2 class="text-xl font-bold text-brand-charcoal mb-2">محصولی در این برند موجود نیست</h2>
        <p class="text-gray-500 mb-6">در حال حاضر محصولی برای این برند ثبت نشده است.</p>
        <a href="{{ route('brands.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
            بازگشت به برندها
        </a>
    </div>
    @endif
</div>
@endsection
