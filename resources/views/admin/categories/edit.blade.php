@extends('components.admin-layout')

@section('header')
    ویرایش دسته‌بندی
@stop

@section('content')
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="bg-white rounded-lg shadow overflow-hidden">
            @csrf
            @method('PUT')
            <div class="px-6 py-6">
                <h2 class="text-xl font-medium text-brand-charcoal mb-6">ویرایش دسته‌بندی: {{ $category->name_fa }}</h2>

                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label for="name_fa" class="block text-sm font-medium text-gray-700 mb-1">نام فارسی *</label>
                        <input type="text" name="name_fa" id="name_fa" value="{{ old('name_fa', $category->name_fa) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                               required maxlength="255">
                        @error('name_fa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name_en" class="block text-sm font-medium text-gray-700 mb-1">نام انگلیسی</label>
                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $category->name_en) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                               maxlength="255">
                        @error('name_en')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">اسلاگ (اختیاری)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                               maxlength="255">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">اگر خالی بگذارید، خودکار از نام انگلیسی تولید می‌شود.</p>
                    </div>

                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">دسته والد</label>
                        <select name="parent_id" id="parent_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent">
                            <option value="">--- سطح ریشه (بدون والد) ---</option>
                            @foreach($parents as $parent)
                                @if($parent->id != $category->id)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name_fa }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">آیکون (اختیاری)</label>
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                               placeholder="tag" maxlength="50">
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">نام آیکون از Lucide (مثل: tag, bike, truck)</p>
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center mb-0">
                            <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-brand-red focus:ring-brand-red border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm font-medium text-gray-900">
                                فعال
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 text-right">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors mr-2">
                    انصراف
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>
@stop