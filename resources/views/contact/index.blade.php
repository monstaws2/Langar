@extends('layouts.app')

@section('title', 'تماس با ما')

@section('content')
<div class="bg-zinc-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-sm text-zinc-500 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-brand-red">خانه</a>
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <span class="text-zinc-800">تماس با ما</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact info -->
            <div class="space-y-4">
                <div class="bg-white rounded-2xl border border-zinc-200 p-6">
                    <h2 class="text-lg font-bold text-zinc-900 mb-5">راه‌های ارتباطی</h2>
                    <ul class="space-y-5">
                        <li class="flex items-start gap-3">
                            <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-zinc-800">آدرس</p>
                                <p class="text-sm text-zinc-500 leading-relaxed">گیلان، لنگرود، راه پشته، جنب افق کوروش</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-zinc-800">تلفن تماس</p>
                                <a href="tel:+989936492894" class="text-sm text-zinc-500 font-num hover:text-brand-red" dir="ltr">۰۹۹۳۶۴۹۲۸۹۴</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="shrink-0 w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                                <i data-lucide="message-circle" class="w-5 h-5"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-zinc-800">واتساپ</p>
                                <a href="https://wa.me/989936492894" target="_blank" rel="noopener" class="text-sm text-zinc-500 font-num hover:text-green-600" dir="ltr">۰۹۹۳۶۴۹۲۸۹۴</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-zinc-800">ایمیل</p>
                                <a href="mailto:info@khanemotor.ir" class="text-sm text-zinc-500 hover:text-brand-red" dir="ltr">info@khanemotor.ir</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="shrink-0 w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-zinc-800">ساعات کاری</p>
                                <p class="text-sm text-zinc-500 leading-relaxed">هر روز ساعت ۹ صبح تا ۹ شب</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-zinc-200 p-6 sm:p-8">
                    <h1 class="text-xl font-bold text-zinc-900 mb-2">پیام خود را ارسال کنید</h1>
                    <p class="text-sm text-zinc-500 mb-6">پرسش‌ها و درخواست‌های خود را برای ما ارسال کنید؛ در کوتاه‌ترین زمان پاسخ می‌دهیم.</p>

                    @if (session('success'))
                        <div class="mb-6 flex items-center gap-2 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-zinc-700 mb-1.5">نام و نام خانوادگی</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none @error('name') border-brand-red @enderror"
                                    placeholder="نام خود را وارد کنید">
                                @error('name') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-zinc-700 mb-1.5">شماره تماس</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required dir="ltr"
                                    class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm text-right focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none @error('phone') border-brand-red @enderror"
                                    placeholder="شماره تلفن خود را وارد کنید">
                                @error('phone') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-zinc-700 mb-1.5">ایمیل</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required dir="ltr"
                                class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm text-right focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none @error('email') border-brand-red @enderror"
                                placeholder="ایمیل خود را وارد کنید">
                            @error('email') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-zinc-700 mb-1.5">موضوع</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none @error('subject') border-brand-red @enderror"
                                placeholder="موضوع پیام">
                            @error('subject') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-zinc-700 mb-1.5">متن پیام</label>
                            <textarea id="message" name="message" rows="5" required
                                class="w-full rounded-xl border border-zinc-300 px-4 py-2.5 text-sm focus:border-brand-red focus:ring-1 focus:ring-brand-red outline-none resize-none @error('message') border-brand-red @enderror"
                                placeholder="پیام خود را وارد کنید">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-brand-red px-6 py-3 text-sm font-bold text-white hover:bg-brand-red/90 transition-colors">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            ارسال پیام
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
