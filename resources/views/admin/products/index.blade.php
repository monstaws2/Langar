@extends('components.admin-layout')

@section('header')
    محصولات
@stop

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center px-4 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                افزودن محصول جدید
            </a>
            <div class="flex gap-4">
                <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center gap-2">
                    <select name="category_id" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
                        <option value="">همه دسته‌بندی‌ها</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ request()->input('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>

                    <select name="brand_id" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
                        <option value="">همه برندها</option>
                        @foreach($brands as $id => $name)
                            <option value="{{ $id }}" {{ request()->input('brand_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>

                    <select name="is_active" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="1" {{ request()->input('is_active') == '1' ? 'selected' : '' }}>فعال</option>
                        <option value="0" {{ request()->input('is_active') == '0' ? 'selected' : '' }}>غیرفعال</option>
                    </select>

                    <input type="text" name="search" placeholder="جستجو" value="{{ request()->input('search') }}" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">تصویر</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">نام</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">برند</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">دسته</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">قیمت</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">موجودی</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Work</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($product->images->count())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name_fa }} image" class="w-12 h-12 object-cover rounded-full">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <i data-lucide="image-off" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brand-charcoal">{{ $product->name_fa }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->brand->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category->name_fa }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium font-num">{{ number_format($product->price) }} تومان</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium font-num">{{ $product->stock_quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($product->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">فعال</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">غیرفعال</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i data-lucide="edit" class="h-4 w-4"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('آیا از حذف این محصول مطمئن هستید؟');">
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
                            <td colspan="9" class="py-6 text-center text-gray-500">
                                هیچ محصولی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
        });
    </script>
@stop