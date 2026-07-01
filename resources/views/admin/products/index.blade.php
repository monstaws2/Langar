@extends('layouts.admin')

@section('title', 'مدیریت محصولات')

@section('content')
<div class="space-y-6" x-data="{ deleteId: null }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">مدیریت محصولات</h1>
            <p class="text-sm text-gray-500 mt-1">لیست کامل محصولات فروشگاه لنگر موتور</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>افزودن محصول</span>
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2" x-data="{ show: true }" x-show="show" x-transition>
            <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Filters --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 sm:p-5">
        <form method="GET" :action="'{{ route('admin.products.index') }}'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="relative">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجوی نام یا شناسه..." class="w-full bg-gray-50 rounded-lg pr-9 pl-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
            </div>
            <select name="category_id" class="bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                <option value="">همه دسته‌بندی‌ها</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="brand_id" class="bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                <option value="">همه برندها</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(request('brand_id') == $brand->id)>{{ $brand->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <select name="status" class="flex-1 bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="active" @selected(request('status') === 'active')>فعال</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>غیرفعال</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-brand-charcoal text-white rounded-lg text-sm font-medium hover:bg-brand-charcoal-light transition-colors">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center" title="پاک کردن فیلترها">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-right">
                        <th class="px-6 py-3 font-medium">تصویر</th>
                        <th class="px-6 py-3 font-medium">نام محصول</th>
                        <th class="px-6 py-3 font-medium">قیمت (تومان)</th>
                        <th class="px-6 py-3 font-medium">موجودی</th>
                        <th class="px-6 py-3 font-medium">دسته‌بندی</th>
                        <th class="px-6 py-3 font-medium">برند</th>
                        <th class="px-6 py-3 font-medium">وضعیت</th>
                        <th class="px-6 py-3 font-medium text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="image" class="w-5 h-5 text-gray-300"></i>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-brand-charcoal max-w-[220px] truncate">{{ $product->name }}</div>
                            <div class="text-xs text-gray-400 font-num mt-0.5">{{ $product->slug }}</div>
                        </td>
                        <td class="px-6 py-4 font-num font-medium text-gray-800">{{ \App\Support\Format::price($product->price) }}</td>
                        <td class="px-6 py-4">
                            @php $lowStock = $product->stock < 5; @endphp
                            <span class="font-num font-medium {{ $lowStock ? 'text-brand-red' : 'text-gray-700' }}">{{ \App\Support\Format::digits($product->stock) }}</span>
                            @if($lowStock)
                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-brand-red inline-block mr-1"></i>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->brand?->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    فعال
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    غیرفعال
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.products.edit', $product) }}" class="p-2 rounded-lg text-gray-500 hover:bg-brand-red/10 hover:text-brand-red transition-colors" title="ویرایش">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <button type="button" @click="deleteId = {{ $product->id }}" class="p-2 rounded-lg text-gray-500 hover:bg-red-50 hover:text-brand-red transition-colors" title="حذف">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="package-x" class="w-7 h-7"></i>
                                </div>
                                <div class="text-sm">هیچ محصولی یافت نشد.</div>
                                <a href="{{ route('admin.products.create') }}" class="text-sm font-medium text-brand-red hover:text-brand-red-dark transition-colors">افزودن اولین محصول</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    {{-- Delete confirmation modal --}}
    <div x-show="deleteId !== null" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.outside="deleteId = null" x-transition class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-brand-red"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal text-lg">حذف محصول</h3>
                    <p class="text-sm text-gray-500 mt-0.5">آیا از حذف این محصول مطمئن هستید؟</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3 mb-5">این عملیات قابل بازگشت نیست و تصویر محصول نیز حذف خواهد شد.</p>
            <div class="flex gap-3">
                <form :action="'/admin/products/' + deleteId" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors">بله، حذف کن</button>
                </form>
                <button type="button" @click="deleteId = null" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">انصراف</button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.anime) {
            anime({
                targets: '.space-y-6 > *',
                opacity: [0, 1],
                translateY: [12, 0],
                duration: 400,
                delay: anime.stagger(60),
                easing: 'easeOutCubic',
            });
        }
        window.renderIcons();
    });
</script>
@endpush
@endsection
