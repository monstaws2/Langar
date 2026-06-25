@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('brands.index') }}" class="inline-flex items-center gap-1 text-brand-red hover:text-brand-red-dark font-semibold mb-6">
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        بازگشت به برندها
    </a>

    <!-- Brand header -->
    <div class="bg-white rounded-2xl shadow-sm p-6 sm:p-8 mb-10">
        <div class="flex flex-col sm:flex-row items-center gap-6 text-center sm:text-right">
            <div class="bg-brand-offwhite rounded-2xl w-32 h-32 flex items-center justify-center shrink-0">
                <i data-lucide="bike" class="w-16 h-16 text-brand-charcoal/40"></i>
            </div>
            <div>
                <h1 class="text-3xl font-extrabold text-brand-charcoal">{{ $brand->name }}</h1>
                <span class="font-num text-sm uppercase tracking-widest text-gray-400">{{ $brand->slug }}</span>
                <div class="mt-4">
                    <span class="inline-flex items-center gap-2 bg-brand-red/10 text-brand-red rounded-lg px-4 py-2 text-sm font-semibold">
                        <i data-lucide="package" class="w-4 h-4"></i>
                        <span class="font-num">{{ \App\Support\Format::digits(count($products)) }}</span> محصول
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products -->
    <h2 class="text-xl font-extrabold text-brand-charcoal mb-6">محصولات {{ $brand->name }}</h2>

    @if(count($products) > 0)
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($products as $product)
            @include('partials.product-card', ['product' => $product])
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
        <i data-lucide="package-open" class="w-14 h-14 mx-auto text-gray-300"></i>
        <h2 class="text-2xl font-semibold text-brand-charcoal mt-4">محصولی در این برند موجود نیست</h2>
        <a href="{{ route('brands.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition">
            بازگشت به برندها
        </a>
    </div>
    @endif
</div>
@endsection
