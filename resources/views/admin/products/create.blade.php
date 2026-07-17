@extends('layouts.admin')

@section('title', 'افزودن محصول')

@section('content')
<div class="space-y-6 max-w-4xl">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">افزودن محصول جدید</h1>
            <p class="text-sm text-gray-500 mt-1">فرم ایجاد محصول جدید در فروشگاه</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
            <span>بازگشت</span>
        </a>
    </div>

    {{-- Flash errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
            <span>لطفاً خطاهای فرم را برطرف کنید.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-brand-charcoal mb-2">نام محصول <span class="text-brand-red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all" placeholder="مثال: لنت ترمز جلو پژو ۲۰۶">
                @error('name') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label for="slug" class="block text-sm font-medium text-brand-charcoal mb-2">شناسه (slug)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" dir="ltr" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num" placeholder="peugeot-206-front-brake-pad">
                <p class="text-xs text-gray-400 mt-1.5">آدرس محصول در سایت. اگر خالی بگذارید، به‌صورت خودکار از نام محصول ساخته می‌شود.</p>
                @error('slug') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-brand-charcoal mb-2">توضیحات</label>
            <textarea id="description" name="description" rows="4" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all resize-y" placeholder="توضیحات کامل محصول...">{{ old('description') }}</textarea>
            @error('description') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Price --}}
            <div>
                <label for="price" class="block text-sm font-medium text-brand-charcoal mb-2">قیمت (تومان) <span class="text-brand-red">*</span></label>
                <div class="relative">
                    <input type="number" id="price" name="price" value="{{ old('price') }}" required min="0" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 pl-16 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num" placeholder="۰">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">تومان</span>
                </div>
                @error('price') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            {{-- Stock --}}
            <div>
                <label for="stock" class="block text-sm font-medium text-brand-charcoal mb-2">موجودی <span class="text-brand-red">*</span></label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required min="0" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num" placeholder="۰">
                @error('stock') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            {{-- is_active --}}
            <div>
                <label class="block text-sm font-medium text-brand-charcoal mb-2">وضعیت محصول</label>
                <label class="flex items-center gap-3 bg-gray-50 rounded-lg px-4 py-2.5 border border-gray-200 cursor-pointer hover:bg-gray-100 transition-colors h-[46px]">
                    <button type="button" role="switch" @click="$refs.toggle.checked = !$refs.toggle.checked" :class="$refs.toggle.checked ? 'bg-brand-red' : 'bg-gray-300'" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors shrink-0">
                        <span :class="$refs.toggle.checked ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"></span>
                    </button>
                    <input type="checkbox" x-ref="toggle" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="hidden">
                    <span class="text-sm text-gray-600" x-text="$refs.toggle.checked ? 'فعال' : 'غیرفعال'">فعال</span>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Category --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-brand-charcoal mb-2">دسته‌بندی <span class="text-brand-red">*</span></label>
                <select id="category_id" name="category_id" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                    <option value="">انتخاب دسته‌بندی...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            {{-- Brand --}}
            <div>
                <label for="brand_id" class="block text-sm font-medium text-brand-charcoal mb-2">برند <span class="text-brand-red">*</span></label>
                <select id="brand_id" name="brand_id" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all">
                    <option value="">انتخاب برند...</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
                @error('brand_id') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Main image + gallery --}}
        <div class="space-y-5">
            <div>
                <label for="image" class="block text-sm font-medium text-brand-charcoal mb-2">تصویر اصلی</label>
                <div x-data="{ preview: null, fileName: '' }" class="relative">
                    <div @click="$refs.fileInput.click()" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-brand-red hover:bg-red-50/30 transition-colors">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                <i data-lucide="upload-cloud" class="w-6 h-6 text-gray-400"></i>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span x-show="!fileName">برای آپلود تصویر اصلی کلیک کنید یا بکشید</span>
                                <span x-show="fileName" x-text="fileName" class="font-medium text-brand-charcoal"></span>
                            </div>
                            <p class="text-xs text-gray-400">PNG، JPG تا ۲ مگابایت. این تصویر در صفحه محصول به‌عنوان تصویر اصلی نمایش داده می‌شود.</p>
                        </div>
                        <img x-show="preview" :src="preview" class="mt-4 max-h-40 mx-auto rounded-lg" alt="پیش‌نمایش">
                    </div>
                    <input type="file" x-ref="fileInput" name="image" id="image" accept="image/*" class="hidden" @change="const f = $event.target.files[0]; if (f) { fileName = f.name; preview = URL.createObjectURL(f); }">
                </div>
                @error('image') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="gallery_images" class="block text-sm font-medium text-brand-charcoal mb-2">تصاویر گالری</label>
                <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*" class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-red file:px-4 file:py-2 file:text-white hover:file:bg-red-700 transition-colors">
                <p class="text-xs text-gray-400 mt-1.5">تصاویر اضافی محصول که در صفحه جزئیات زیر تصویر اصلی نمایش داده می‌شوند.</p>
                @error('gallery_images.*') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>
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
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="70" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all" placeholder="مثال: لنت ترمز جلو پژو ۲۰۶ | خانه‌ی موتور">
                    <p class="text-xs text-gray-400 mt-1.5">عنوانی که در نتیجه گوگل و تب مرورگر نمایش داده می‌شود. اگر خالی بماند، نام محصول استفاده می‌شود.</p>
                    @error('meta_title') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- SEO meta description --}}
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-brand-charcoal mb-2">توضیح متا (Meta Description)</label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="320" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all resize-y" placeholder="یک توضیح کوتاه و جذاب که مشتری را ترغیب به کلیک می‌کند...">{{ old('meta_description') }}</textarea>
                    <p class="text-xs text-gray-400 mt-1.5">توضیح کوتاهی که زیر عنوان در نتایج گوگل نمایش داده می‌شود. اگر خالی بماند، از نام، برند، دسته‌بندی و توضیحات محصول ساخته می‌شود.</p>
                    @error('meta_description') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- SEO tags --}}
                <div>
                    <label for="seo_tags" class="block text-sm font-medium text-brand-charcoal mb-2">کلمات کلیدی (SEO Tags)</label>
                    <input type="text" id="seo_tags" name="seo_tags" value="{{ old('seo_tags') }}" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all" placeholder="مثال: لنت ترمز، پژو ۲۰۶، قطعات ترمز">
                    <p class="text-xs text-gray-400 mt-1.5">کلماتی که مشتریان برای پیدا کردن این محصول جستجو می‌کنند، با ویرگول جدا کنید. اگر خالی بماند، از نام، برند، دسته‌بندی و مدل‌های سازگار ساخته می‌شود.</p>
                    @error('seo_tags') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Canonical URL (advanced) --}}
                <div>
                    <label for="canonical_url" class="block text-sm font-medium text-brand-charcoal mb-2">آدرس Canonical <span class="text-gray-400 font-normal">(پیشرفته)</span></label>
                    <input type="url" id="canonical_url" name="canonical_url" value="{{ old('canonical_url') }}" dir="ltr" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num" placeholder="https://khanemotor.com/products/...">
                    <p class="text-xs text-gray-400 mt-1.5">فقط در موارد خاص لازم است (مثلاً وقتی همین محصول در آدرس دیگری هم نمایش داده می‌شود). در حالت عادی خالی بگذارید.</p>
                    @error('canonical_url') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">انصراف</a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>ذخیره محصول</span>
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
