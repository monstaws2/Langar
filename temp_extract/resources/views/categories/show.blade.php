@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="bg-zinc-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-brand-red">خانه</a>
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <span class="text-brand-charcoal">{{ $category->name }}</span>
        </nav>

        <!-- Header -->
        <div class="bg-brand-charcoal rounded-2xl p-8 mb-8 flex items-center gap-5 text-white">
            <span class="w-16 h-16 rounded-2xl bg-brand-red flex items-center justify-center shrink-0">
                <i data-lucide="{{ $category->icon ?? 'package' }}" class="w-8 h-8"></i>
            </span>
            <div>
                <h1 class="text-2xl font-extrabold">{{ $category->name }}</h1>
                <p class="text-gray-400 text-sm mt-1">
                    <span class="font-num">{{ \App\Support\Format::digits($products->count()) }}</span> محصول در این دسته‌بندی
                </p>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                <i data-lucide="package-x" class="w-12 h-12 text-gray-300 mx-auto"></i>
                <p class="text-gray-500 mt-4">در حال حاضر محصولی در این دسته‌بندی موجود نیست.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
