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
                <label for="slug" class="block text-sm font-medium text-brand-charcoal mb-2">شناسه (slug)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" dir="ltr" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num">
                <p class="text-xs text-gray-400 mt-1.5">آدرس محصول در سایت. اگر خالی بگذارید، به‌صورت خودکار از نام محصول ساخته می‌شود.</p>
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

        {{-- Main image + gallery --}}
        @php
            $primaryGalleryImageId = old('primary_image_id', $product->productImages->firstWhere('is_primary', true)?->id);
            $currentMainImage = $product->image
                ? Storage::url($product->image)
                : ($product->productImages->first() ? Storage::url($product->productImages->first()->image_path) : null);
        @endphp
        <div class="space-y-5">
            <div>
                <label for="image" class="block text-sm font-medium text-brand-charcoal mb-2">تصویر اصلی</label>
                <div x-data="{ preview: @js($currentMainImage), fileName: '{{ $product->image ? basename($product->image) : '' }}' }" class="relative">
                    @if($currentMainImage)
                        <div class="mb-3 flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shrink-0">
                                <img :src="preview" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-brand-charcoal truncate" x-text="fileName || 'تصویر اصلی فعلی'"></div>
                                <div class="text-xs text-gray-400 mt-0.5">این تصویر در صفحه محصول به‌عنوان تصویر اصلی نمایش داده می‌شود</div>
                            </div>
                        </div>
                    @endif
                    <div @click="$refs.fileInput.click()" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-brand-red hover:bg-red-50/30 transition-colors">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <i data-lucide="upload-cloud" class="w-6 h-6 text-gray-400"></i>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span x-show="!fileName">برای جایگزینی تصویر اصلی کلیک کنید</span>
                                <span x-show="fileName" x-text="'انتخاب شد: ' + fileName" class="font-medium text-brand-charcoal"></span>
                            </div>
                            <p class="text-xs text-gray-400">PNG، JPG تا ۲ مگابایت — اگر انتخاب شود، به‌جای تصویر فعلی ذخیره می‌شود</p>
                        </div>
                        <img x-show="preview" :src="preview" class="mt-4 max-h-40 mx-auto rounded-lg" alt="پیش‌نمایش">
                    </div>
                    <input type="file" x-ref="fileInput" name="image" id="image" accept="image/*" class="hidden" @change="const f = $event.target.files[0]; if (f) { fileName = f.name; preview = URL.createObjectURL(f); }">
                </div>
                @error('image') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="gallery_images" class="block text-sm font-medium text-brand-charcoal mb-2">افزودن تصاویر گالری</label>
                <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-red file:px-4 file:py-2 file:text-white hover:file:bg-red-700 transition-colors">
                <p class="text-xs text-gray-400 mt-1.5">این تصاویر در صفحه محصول زیر تصویر اصلی نمایش داده می‌شوند.</p>
                @error('gallery_images.*') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            @if($product->productImages->count())
                <div>
                    <label class="block text-sm font-medium text-brand-charcoal mb-2">تعیین تصویر اصلی از گالری</label>
                    <p class="text-xs text-gray-400 mb-3">اگر یکی از تصاویر گالری را انتخاب کنید، همان تصویر به‌عنوان تصویر اصلی محصول ذخیره می‌شود.</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach($product->productImages as $galleryImage)
                            <label class="block cursor-pointer">
                                <input type="radio" name="primary_image_id" value="{{ $galleryImage->id }}" @checked((string) old('primary_image_id', $primaryGalleryImageId) === (string) $galleryImage->id) class="peer sr-only">
                                <div class="rounded-xl border-2 border-gray-200 bg-gray-50 p-2 transition-all peer-checked:border-brand-red peer-checked:ring-2 peer-checked:ring-brand-red/20">
                                    <div class="aspect-square rounded-lg overflow-hidden bg-white border border-gray-200">
                                        <img src="{{ Storage::url($galleryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="mt-2 flex items-center justify-between gap-2 text-[11px] text-gray-500">
                                        <span class="truncate">{{ basename($galleryImage->image_path) }}</span>
                                        <span class="shrink-0 rounded-full px-2 py-0.5 {{ $galleryImage->is_primary ? 'bg-brand-red text-white' : 'bg-gray-200 text-gray-600' }}">{{ $galleryImage->is_primary ? 'اصلی' : 'گالری' }}</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- SEO section --}}
        <div class="pt-6 border-t border-gray-100">
            <div class="flex items-center gap-2 mb-1">
                <i data-lucide="search" class="w-4 h-4 text-brand-red"></i>
                <h2 class="text-base font-semibold text-brand-charcoal">سئو (SEO)</h2>
            </div>
            <p class="text-xs text-gray-500 mb-4">این بخش اختیاری است. اگر خالی بگذارید، سایت به‌صورت خودکار از نام، برند و دسته‌بندی محصول یک نسخه مناسب می‌سازد.</p>

            <div class="space-y-5">
                {{-- SEO title --}}
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-brand-charcoal mb-2">عنوان سئو (Meta Title)</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" maxlength="70" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all" placeholder="مثال: لنت ترمز جلو پژو ۲۰۶ | خانه‌ی موتور">
                    <p class="text-xs text-gray-400 mt-1.5">عنوانی که در نتیجه گوگل و تب مرورگر نمایش داده می‌شود. اگر خالی بماند، نام محصول استفاده می‌شود.</p>
                    @error('meta_title') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- SEO meta description --}}
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-brand-charcoal mb-2">توضیح متا (Meta Description)</label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="320" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all resize-y" placeholder="یک توضیح کوتاه و جذاب که مشتری را ترغیب به کلیک می‌کند...">{{ old('meta_description', $product->meta_description) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1.5">توضیح کوتاهی که زیر عنوان در نتایج گوگل نمایش داده می‌شود. اگر خالی بماند، از نام، برند، دسته‌بندی و توضیحات محصول ساخته می‌شود.</p>
                    @error('meta_description') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- SEO tags --}}
                <div>
                    <label for="seo_tags" class="block text-sm font-medium text-brand-charcoal mb-2">کلمات کلیدی (SEO Tags)</label>
                    <input type="text" id="seo_tags" name="seo_tags" value="{{ old('seo_tags', $product->seo_tags) }}" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all" placeholder="مثال: لنت ترمز، پژو ۲۰۶، قطعات ترمز">
                    <p class="text-xs text-gray-400 mt-1.5">کلماتی که مشتریان برای پیدا کردن این محصول جستجو می‌کنند، با ویرگول جدا کنید. اگر خالی بماند، از نام، برند، دسته‌بندی و مدل‌های سازگار ساخته می‌شود.</p>
                    @error('seo_tags') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Canonical URL (advanced) --}}
                <div>
                    <label for="canonical_url" class="block text-sm font-medium text-brand-charcoal mb-2">آدرس Canonical <span class="text-gray-400 font-normal">(پیشرفته)</span></label>
                    <input type="url" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $product->canonical_url) }}" dir="ltr" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num" placeholder="https://khanemotor.com/products/...">
                    <p class="text-xs text-gray-400 mt-1.5">فقط در موارد خاص لازم است (مثلاً وقتی همین محصول در آدرس دیگری هم نمایش داده می‌شود). در حالت عادی خالی بگذارید.</p>
                    @error('canonical_url') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>
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
