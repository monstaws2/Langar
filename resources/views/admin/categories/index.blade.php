@extends('layouts.admin')

@section('title', 'مدیریت دسته‌بندی‌ها')

@section('content')
<div class="space-y-6" x-data="{ deleteId: null }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">مدیریت دسته‌بندی‌ها</h1>
            <p class="text-sm text-gray-500 mt-1">دسته‌بندی محصولات فروشگاه</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>افزودن دسته‌بندی</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
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
        <form method="GET" :action="'{{ route('admin.categories.index') }}'" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجوی دسته‌بندی..." class="w-full bg-gray-50 rounded-lg pr-9 pl-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
            </div>
            <select name="status" class="bg-gray-50 rounded-lg px-3 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                <option value="">همه وضعیت‌ها</option>
                <option value="active" @selected(request('status') === 'active')>فعال</option>
                <option value="inactive" @selected(request('status') === 'inactive')>غیرفعال</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2.5 bg-brand-charcoal text-white rounded-lg text-sm font-medium hover:bg-brand-charcoal-light transition-colors">
                    <i data-lucide="filter" class="w-4 h-4"></i>
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center" title="پاک کردن">
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
                        <th class="px-6 py-3 font-medium">نام دسته‌بندی</th>
                        <th class="px-6 py-3 font-medium">شناسه</th>
                        <th class="px-6 py-3 font-medium">آیکون</th>
                        <th class="px-6 py-3 font-medium">تعداد محصولات</th>
                        <th class="px-6 py-3 font-medium">وضعیت</th>
                        <th class="px-6 py-3 font-medium text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-brand-charcoal flex items-center justify-center shrink-0">
                                    <i data-lucide="{{ $category->icon ?: 'folder' }}" class="w-5 h-5 text-gray-300"></i>
                                </div>
                                <div class="font-medium text-brand-charcoal">{{ $category->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500 font-num text-xs" dir="ltr">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-gray-600 font-num text-xs" dir="ltr">{{ $category->icon ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 font-num">{{ \App\Support\Format::digits($category->products_count) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($category->is_active)
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
                                <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 rounded-lg text-gray-500 hover:bg-brand-red/10 hover:text-brand-red transition-colors" title="ویرایش">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <button type="button" @click="deleteId = {{ $category->id }}" class="p-2 rounded-lg text-gray-500 hover:bg-red-50 hover:text-brand-red transition-colors" title="حذف">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="folder-x" class="w-7 h-7"></i>
                                </div>
                                <div class="text-sm">هیچ دسته‌بندی یافت نشد.</div>
                                <a href="{{ route('admin.categories.create') }}" class="text-sm font-medium text-brand-red hover:text-brand-red-dark transition-colors">افزودن اولین دسته‌بندی</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

    {{-- Delete modal --}}
    <div x-show="deleteId !== null" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div @click.outside="deleteId = null" x-transition class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-brand-red"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal text-lg">حذف دسته‌بندی</h3>
                    <p class="text-sm text-gray-500 mt-0.5">آیا از حذف این دسته‌بندی مطمئن هستید؟</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3 mb-5">در صورت وجود محصول در این دسته‌بندی، حذف امکان‌پذیر نخواهد بود.</p>
            <div class="flex gap-3">
                <form :action="'/admin/categories/' + deleteId" method="POST" class="flex-1">
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
