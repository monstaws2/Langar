<x-admin-layout :header="'Edit Product'">
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

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            @csrf
            @method('PUT')

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Product Information</h2>

                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="name_fa">Product Name (Farsi) *</label>
                        <input type="text" name="name_fa" id="name_fa" value="{{ old('name_fa', $product->name_fa) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="name_en">Product Name (English) *</label>
                        <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $product->name_en) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="slug">URL Slug (optional)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to auto-generate from product name</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description_fa">Description (Farsi)</label>
                        <textarea name="description_fa" id="description_fa" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description_fa', $product->description_fa) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="description_en">Description (English)</label>
                        <textarea name="description_en" id="description_en" rows="3" class="w-full px-3-full px- border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description_en', $product->description_en) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="price">Price * (Tomans)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="stock_quantity">Stock Quantity *</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="sku">SKU (optional)</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank to auto-generate</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2" for="weight">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="category_id">Category *</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}" {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>
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
                                <option value="{{ $id }}" {{ old('brand_id', $product->brand_id) == $id ? 'selected' : '' }}>
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
                                <option value="{{ $id }}" {{ in_array($id, old('motorcycle_models', $selectedMotorcycleModels)) ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple models</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Current Images</h2>
                @if($product->images->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                        @foreach($product->images as $image)
                            <div class="relative border rounded overflow-hidden">
                                @if(Storage::disk('public')->exists($image->image_path))
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product image" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        Image not found
                                    </div>
                                @endif
                                <div class="absolute top-2 left-2 flex items-center space-x-2 bg-black bg-opacity-50 text-white px-2 py-1 text-xs rounded">
                                    @if($image->is_primary)
                                        <span>Primary</span>
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <button type="button" onclick="if(confirm('Set this as primary image?')) {
                                            const form = document.createElement('form');
                                            form.method = 'POST';
                                            form.action = '{{ route('admin.products.set-primary', [$product->id, $image->id]) }}';
                                            form.innerHTML = '@csrf';
                                            document.body.appendChild(form);
                                            form.submit();
                                        }" class="hover:text-indigo-400">
                                            Set as Primary
                                        </button>
                                    @endif
                                    <button type="button" onclick="if(confirm('Delete this image?')) {
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = '{{ route('admin.products.delete-image', [$product->id, $image->id]) }}';
                                        form.innerHTML = '@csrf @method(\"DELETE\")';
                                        document.body.appendChild(form);
                                        form.submit();
                                    }" class="hover:text-red-400">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No images uploaded yet.</p>
                @endif
            </div>

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Add More Images</h2>
                <p class="mb-4 text-gray-600 dark:text-gray-400">Upload additional images for your product.</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 mb-2" for="images">Product Images</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Supported formats: JPG, PNG, GIF, SVG (Max 2MB each)</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <h2 class="text-xl font-bold mb-4">Status</h2>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
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
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>