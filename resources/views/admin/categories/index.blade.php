@extends('components.admin-layout')

@section('header')
    دسته‌بندی‌ها
@stop

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center px-4 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                افزودن دسته‌بندی جدید
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-medium text-brand-charcoal">دسته‌بندی‌ها</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                عنوان
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                دسته والد
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                وضعیت
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">عملیات</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @if($categories->isEmpty())
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-500">
                                    هیچ دسته‌بندی یافت نشد.
                                </td>
                            </tr>
                        @else
                            @foreach($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brand-charcoal">
                                        {{ $category->name_fa }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($category->parent)
                                            {{ $category->parent->name_fa }}
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                ریشه
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($category->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                فعال
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                غیرفعال
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i data-lucide="edit" class="h-4 w-4"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟ این عمل غير قابل بازگشت است.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{ $links ?? $categories->links() }}
    </div>
@stop