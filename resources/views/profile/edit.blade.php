@extends('layouts.app')

@section('title', 'ویرایش پروفایل')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('dashboard') }}" class="hover:text-brand-red transition">حساب کاربری</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">ویرایش پروفایل</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Update Profile Info --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-brand-charcoal mb-1 flex items-center gap-2">
                    <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                    اطلاعات شخصی
                </h2>
                <p class="text-sm text-gray-500 mb-6">نام و ایمیل خود را به‌روز کنید.</p>

                <form method="post" action="{{ route('profile.update') }}" class="max-w-xl space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">نام</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-5 py-2.5 rounded-lg text-sm transition">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            ذخیره تغییرات
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-brand-charcoal mb-1 flex items-center gap-2">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                    تغییر رمز عبور
                </h2>
                <p class="text-sm text-gray-500 mb-6">برای امنیت بیشتر، رمز عبور قوی انتخاب کنید.</p>

                <form method="post" action="{{ route('password.update') }}" class="max-w-xl space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور فعلی</label>
                        <input type="password" id="current_password" name="current_password" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red">
                        @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور جدید</label>
                        <input type="password" id="password" name="password" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تکرار رمز عبور جدید</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 bg-brand-charcoal text-white hover:bg-gray-800 px-5 py-2.5 rounded-lg text-sm transition">
                            <i data-lucide="key" class="w-4 h-4"></i>
                            به‌روزرسانی رمز عبور
                        </button>
                    </div>
                </form>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white rounded-xl border border-red-200 p-6">
                <h2 class="text-lg font-bold text-red-600 mb-1 flex items-center gap-2">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                    حذف حساب کاربری
                </h2>
                <p class="text-sm text-gray-500 mb-6">با حذف حساب، تمام اطلاعات و سفارش‌های شما حذف می‌شود. این عمل غیرقابل بازگشت است.</p>

                <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('آیا از حذف حساب کاربری خود اطمینان دارید؟ این عمل غیرقابل بازگشت است.');">
                    @csrf
                    @method('delete')

                    <div class="max-w-xl">
                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور فعلی برای تأیید</label>
                        <input type="password" id="delete_password" name="password" required
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-red-300 focus:border-red-400 mb-4">
                        @error('password')<p class="text-red-500 text-xs mt-1 mb-2">{{ $message }}</p>@enderror

                        <button type="submit" class="inline-flex items-center gap-2 border border-red-300 text-red-600 hover:bg-red-50 px-5 py-2.5 rounded-lg text-sm transition">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            حذف حساب کاربری
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            {{-- User Card --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-brand-charcoal flex items-center justify-center text-white text-lg font-bold">
                        {{ mb_substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-brand-charcoal">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-gray-400"></i>
                        <span>داشبورد</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400"></i>
                        <span>سفارش‌های من</span>
                    </a>
                </div>
            </div>

            {{-- Quick Help --}}
            <div class="bg-brand-charcoal rounded-xl p-5 text-white">
                <h3 class="font-bold mb-2 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5 text-brand-orange"></i>
                    امنیت حساب
                </h3>
                <p class="text-sm text-gray-400 mb-4">رمز عبور قوی و منحصربه‌فرد برای محافظت از حساب خود استفاده کنید.</p>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-green-400 shrink-0"></i>
                        <span>حداقل ۸ کاراکتر</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-green-400 shrink-0"></i>
                        <span>شامل حروف و اعداد</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="check" class="w-4 h-4 text-green-400 shrink-0"></i>
                        <span>از کاراکترهای خاص استفاده کنید</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
