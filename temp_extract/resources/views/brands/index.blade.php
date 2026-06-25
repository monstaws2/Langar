@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-right">
        <h1 class="text-3xl font-extrabold text-brand-charcoal">برندها</h1>
        <p class="text-gray-500 mt-2">برندهای معتبر موتورسیکلت</p>
    </div>

    @if(count($brands) > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        @foreach($brands as $brand)
        <a href="{{ route('brands.show', $brand->slug) }}" class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition overflow-hidden group">
            <div class="bg-brand-offwhite h-36 flex items-center justify-center">
                <i data-lucide="bike" class="w-14 h-14 text-brand-charcoal/40 group-hover:text-brand-red transition"></i>
            </div>
            <div class="p-4 text-center">
                <h3 class="text-lg font-bold text-brand-charcoal">{{ $brand->name }}</h3>
                <span class="font-num text-xs uppercase tracking-widest text-gray-400">{{ $brand->slug }}</span>
                <div class="mt-3 inline-flex items-center gap-1 text-sm text-brand-orange font-semibold">
                    مشاهده محصولات
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
        <i data-lucide="store" class="w-14 h-14 mx-auto text-gray-300"></i>
        <h2 class="text-2xl font-semibold text-brand-charcoal mt-4">برندی موجود نیست</h2>
        <p class="text-gray-500 mt-2">لطفاً بعداً دوباره بررسی کنید.</p>
    </div>
    @endif
</div>
@endsection
