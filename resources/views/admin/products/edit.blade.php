@extends('layouts.admin')

@section('title', 'ویرایش محصول')

@section('content')
<div class="space-y-6 max-w-4xl">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">ویرایش محصول</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $product->name }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
            <span>بازگشت</span>
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
            <span>لطفاً خطاهای فرم را برطرف کنید.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-sm font-medium text-brand-charcoal mb-2">نام محصول <span class="text-brand-red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                @error('name') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-brand-charcoal mb-2">شناسه (slug) <span class="text-brand-red">*</span></label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required dir="ltr" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num">
                @error('slug') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-brand-charcoal mb-2">توضیحات</label>
            <textarea id="description" name="description" rows="4" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all resize-y">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label for="price" class="block text-sm font-medium text-brand-charcoal mb-2">قیمت (تومان) <span class="text-brand-red">*</span></label>
                <div class="relative">
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 pl-16 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">تومان</span>
                </div>
                @error('price') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-brand-charcoal mb-2">موجودی <span class="text-brand-red">*</span></label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num">
                @error('stock') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-brand-charcoal mb-2">وضعیت محصول</label>
                <label class="flex items-center gap-3 bg-gray-50 rounded-lg px-4 py-2.5 border border-gray-200 cursor-pointer hover:bg-gray-100 transition-colors h-[46px]">
                    <button type="button" role="switch" @click="$refs.toggle.checked = !$refs.toggle.checked" :class="$refs.toggle.checked ? 'bg-brand-red' : 'bg-gray-300'" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors shrink-0">
                        <span :class="$refs.toggle.checked ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="checkbox" x-ref="toggle" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="hidden">
                    <span class="text-sm text-gray-600" x-text="$refs.toggle.checked ? 'فعال' : 'غیرفعال'">فعال</span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="category_id" class="block text-sm font-medium text-brand-charcoal mb-2">دسته‌بندی <span class="text-brand-red">*</span></label>
                <select id="category_id" name="category_id" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                    <option value="">انتخاب دسته‌بندی...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="brand_id" class="block text-sm font-medium text-brand-charcoal mb-2">برند <span class="text-brand-red">*</span></label>
                <select id="brand_id" name="brand_id" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                    <option value="">انتخاب برند...</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand_id') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Image upload --}}
        <div>
            <label for="image" class="block text-sm font-medium text-brand-charcoal mb-2">تصویر محصول</label>
            <div x-data="{ preview: {{ $product->image ? 'true' : 'false' }}, fileName: '{{ $product->image ? basename($product->image) : '' }}' }" class="relative">
                @if($product->image)
                    <div class="mb-3 flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shrink-0">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-brand-charcoal truncate">{{ basename($product->image) }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">تصویر فعلی</div>
                        </div>
                    </div>
                @endif
                <div @click="$refs.fileInput.click()" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-brand-red hover:bg-red-50/30 transition-colors">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                            <i data-lucide="upload-cloud" class="w-6 h-6 text-gray-400"></i>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span x-show="!fileName">برای آپلود تصویر جدید کلیک کنید</span>
                            <span x-show="fileName" x-text="fileName ? 'انتخاب شد: ' + fileName : ''" class="font-medium text-brand-charcoal"></span>
                        </div>
                        <p class="text-xs text-gray-400">PNG، JPG تا ۲ مگابایت — در صورت انتخاب، تصویر جایگزین می‌شود</p>
                    </div>
                    <img x-show="preview" :src="preview" class="mt-4 max-h-40 mx-auto rounded-lg" alt="پیش‌نمایش">
                </div>
                <input type="file" x-ref="fileInput" name="image" id="image" accept="image/*" class="hidden" @change="const f = $event.target.files[0]; if (f) { fileName = f.name; preview = URL.createObjectURL(f); }">
            </div>
            @error('image') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">انصراف</a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>ذخیره تغییرات</span>
            </button>
        </div>
    </form>

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
