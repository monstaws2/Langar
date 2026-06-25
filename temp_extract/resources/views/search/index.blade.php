@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-right">
        <h1 class="text-3xl font-extrabold text-brand-charcoal">جستجوی محصولات</h1>
        <p class="text-gray-500 mt-2">قطعه مورد نظر خود را پیدا کنید</p>
    </div>

    <!-- Search form -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('search.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="q" class="block text-gray-700 font-semibold mb-2 text-sm">جستجو</label>
                    <input type="text" id="q" name="q" value="{{ $query }}" placeholder="جستجوی قطعات..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                </div>
                <div>
                    <label for="category" class="block text-gray-700 font-semibold mb-2 text-sm">دسته‌بندی</label>
                    <select id="category" name="category" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                        <option value="">تمام دسته‌ها</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="brand" class="block text-gray-700 font-semibold mb-2 text-sm">برند</label>
                    <select id="brand" name="brand" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-transparent">
                        <option value="">تمام برندها</option>
                        @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ $brand == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('search.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm">
                    پاک کردن فیلترها
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-semibold transition text-sm">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    جستجو
                </button>
            </div>
        </form>
    </div>

    <!-- Results -->
    @if(count($products) > 0)
        <h2 class="text-xl font-bold text-brand-charcoal mb-6">
            نتایج جستجو
            @if($query) برای «{{ $query }}» @endif
            (<span class="font-num">{{ \App\Support\Format::digits(count($products)) }}</span> محصول)
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($products as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <i data-lucide="search-x" class="w-14 h-14 mx-auto text-gray-300"></i>
            <h2 class="text-2xl font-semibold text-brand-charcoal mt-4">نتیجه‌ای یافت نشد</h2>
            <p class="text-gray-500 mt-2">لطفاً فیلترهای خود را تغییر دهید و دوباره تلاش کنید.</p>
        </div>
    @endif
</div>
@endsection
