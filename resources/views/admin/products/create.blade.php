<x-admin-layout :header="'Create Product'">
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-200 rounded-md text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-200 rounded-md text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-200 rounded-md text-red-800">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            @csrf

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Product Information</h2>

                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="name_fa">Product Name (Farsi) *</label>
                        <input type="text" name="name_fa" id="name_fa" value="{{ old('name_fa') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="name_en">Product Name (English) *</label>
                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="slug">URL Slug (optional)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to auto-generate from product name</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description_fa">Description (Farsi)</label>
                        <textarea name="description_fa" id="description_fa" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description_fa') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description_en">Description (English)</label>
                        <textarea name="description_en" id="description_en" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description_en') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="price">Price * (Tomans)</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="stock_quantity">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity') }}" required min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="sku">SKU (optional)</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to auto-generate</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="weight">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight') }}" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="category_id">Category *</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="brand_id">Brand *</label>
                        <select name="brand_id" id="brand_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <option value="">Select Brand</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}" {{ old('brand_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Motorcycle Models</label>
                        <select name="motorcycle_models[]" id="motorcycle_models" multiple size="6"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            @foreach($motorcycleModels as $id => $name)
                                <option value="{{ $id }}" {{ in_array($id, old('motorcycle_models', [])) ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple models</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Product Images</h2>
                <p class="mb-4 text-gray-600 dark:text-gray-400">Upload one or more images for your product. The first image will be set as the primary image.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="images">Product Images *</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Supported formats: JPG, PNG, GIF, SVG (Max 2MB each)</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Status</h2>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" checked
                        class="form-checkbox h-4 w-4 text-indigo-600">
                    <label for="is_active" class="ml-2 text-gray-700 dark:text-gray-300">Product is active and visible in store</label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 dark:text-gray-200 font-medium rounded-md transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Create Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>