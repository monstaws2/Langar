@extends('components.admin-layout')

@section('header')
    افزودن مدل موتورسیکلت
@stop

@section('content')
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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

        <form action="{{ route('admin.motorcycle-models.store') }}" method="POST" class="bg-white rounded-lg shadow overflow-hidden">
            @csrf
            <div class="px-6 py-6">
                <h2 class="text-xl font-medium text-brand-charcoal mb-6">افزودن مدل موتورسیکلت جدید</h2>

                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">برند *</label>
                        <select name="brand_id" id="brand_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                                required>
                            <option value="">--- انتخاب برند ---</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">نام مدل *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                               required maxlength="255">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="year_from" class="block text-sm font-medium text-gray-700 mb-1">سال شروع (اختیاری)</label>
                            <input type="number" name="year_from" id="year_from" value="{{ old('year_from') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                                   min="1900" max="{{ date('Y') + 2 }}">
                            @error('year_from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year_to" class="block text-sm font-medium text-gray-700 mb-1">سال پایان (اختیاری)</label>
                            <input type="number" name="year_to" id="year_to" value="{{ old('year_to') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"
                                   min="1900" max="{{ date('Y') + 2 }}">
                            @error('year_to')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center mb-0">
                            <input type="checkbox" name="is_active" id="is_active" {{ old('is_active') ? 'checked' : 'checked' }}
                                   class="h-4 w-4 text-brand-red focus:ring-brand-red border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm font-medium text-gray-900">
                                فعال
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 text-right">
                <a href="{{ route('admin.motorcycle-models.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors mr-2">
                    انصراف
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                    ذخیره مدل
                </button>
            </div>
        </form>
    </div>
@stop