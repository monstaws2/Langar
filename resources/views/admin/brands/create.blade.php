@extends('layouts.admin')

@section('title', 'افزودن برند')

@section('content')
<div class="space-y-6 max-w-2xl">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">افزودن برند جدید</h1>
            <p class="text-sm text-gray-500 mt-1">ایجاد برند برای محصولات</p>
        </div>
        <a href="{{ route('admin.brands.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
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

    <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-sm font-medium text-brand-charcoal mb-2">نام برند <span class="text-brand-red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all" placeholder="مثال: Bosch">
                @error('name') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-brand-charcoal mb-2">شناسه (slug) <span class="text-brand-red">*</span></label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required dir="ltr" class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:bg-white focus:border-brand-red/50 transition-all font-num" placeholder="bosch">
                @error('slug') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Logo upload --}}
        <div>
            <label class="block text-sm font-medium text-brand-charcoal mb-2">لوگوی برند</label>
            <div x-data="{ preview: null, fileName: '' }" class="relative">
                <div @click="$refs.fileInput.click()" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-brand-red hover:bg-red-50/30 transition-colors">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span x-show="!fileName">برای آپلود لوگو کلیک کنید</span>
                            <span x-show="fileName" x-text="fileName" class="font-medium text-brand-charcoal"></span>
                        </div>
                        <p class="text-xs text-gray-400">PNG، JPG تا ۲ مگابایت</p>
                    </div>
                    <img x-show="preview" :src="preview" class="mt-4 max-h-32 mx-auto rounded-lg" alt="پیش‌نمایش">
                </div>
                <input type="file" x-ref="fileInput" name="logo" accept="image/*" class="hidden" @change="const f = $event.target.files[0]; if (f) { fileName = f.name; preview = URL.createObjectURL(f); }">
            </div>
            @error('logo') <p class="text-xs text-brand-red mt-1.5">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-brand-charcoal mb-2">وضعیت</label>
            <label class="flex items-center gap-3 bg-gray-50 rounded-lg px-4 py-2.5 border border-gray-200 cursor-pointer hover:bg-gray-100 transition-colors">
                <button type="button" role="switch" @click="$refs.toggle.checked = !$refs.toggle.checked" :class="$refs.toggle.checked ? 'bg-brand-red' : 'bg-gray-300'" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors shrink-0">
                    <span :class="$refs.toggle.checked ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"></span>
                </button>
                <input type="checkbox" x-ref="toggle" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="hidden">
                <span class="text-sm text-gray-600" x-text="$refs.toggle.checked ? 'فعال' : 'غیرفعال'">فعال</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.brands.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">انصراف</a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-brand-red-dark transition-colors shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>ذخیره برند</span>
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
