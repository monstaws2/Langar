@extends('components.admin-layout')

@section('header')
    برندها
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

        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.brands.create') }}"
               class="inline-flex items-center px-4 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                افزودن برند جدید
            </a>
            <div class="flex gap-4">
                <form action="{{ route('admin.brands.index') }}" method="GET" class="flex items-center gap-2">
                    <select name="is_active" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="1" {{ request()->input('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                        <option value="0" {{ request()->input('is_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
                    </select>

                    <input type="text" name="search" placeholder="جستجو برند..." value="{{ request()->input('search') }}" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
                    <button type="submit" class="px-4 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">لوگو</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">نام</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">اسلاگ</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">عمليات</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($brands as $brand)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $brand->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }} logo" class="w-12 h-12 object-contain rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brand-charcoal">{{ $brand->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-num">{{ $brand->slug }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($brand->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">غیرفعال</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i data-lucide="edit" class="h-4 w-4"></i>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('آیا از حذف این برند مطمئن هستید؟ این عمل غیرقابل بازگشت است.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">
                                هیچ برندی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $brands->links() }}
        </div>
    </div>
@stop