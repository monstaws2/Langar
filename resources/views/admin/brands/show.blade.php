@extends('components.admin-layout')

@section('header')
    نمایش برند
@stop

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-brand-charcoal">{{ $brand->name }}</h2>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.brands.edit', $brand) }}"
                       class="text-indigo-600 hover:text-indigo-900">
                        <i data-lucide="edit" class="h-4 w-4"></i>
                        ویرایش
                    </a>
                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('آیا از حذف این برند مطمئن هستید؟ این عمل غیرقابل بازگشت است.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                            حذف
                        </button>
                    </form>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-500 mb-2">لوگو برند</h3>
                        @if($brand->logo)
                            <div class="aspect-square w-full bg-gray-100 rounded-lg overflow-hidden mb-4">
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }} logo" class="w-full h-full object-center">
                            </div>
                        @else
                            <div class="aspect-square w-full bg-gray-200 rounded-lg flex items-center justify-center">
                                <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                                <p class="text-center text-xs text-gray-500 mt-2">لا Logo</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">نام برند</p>
                            <p class="text-2xl font-bold text-brand-charcoal">{{ $brand->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">اسلاگ</p>
                            <p class="text-xl font-mono text-gray-700">{{ $brand->slug }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">وضعیت</p>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($brand->is_active) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                endif">
                                {{ $brand->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">تاریخ ایجاد</p>
                            <p class="text-gray-500">{{ $brand->created_at->format('Y/m/d') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">تاریخ به‌روزرسانی</p>
                            <p class="text-gray-500">{{ $brand->updated_at->format('Y/m/d') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('admin.brands.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-medium rounded-md hover:bg-gray-300 transition-colors">
                <i data-lucide="chevron-left" class="mr-2 h-4 w-4"></i>
                بازگشت به لیست برندها
            </a>
        </div>
    </div>
@stop