@extends('layouts.app')

@section('title', 'شرایط ارسال و بازگشت')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">شرایط ارسال و بازگشت</span>
    </nav>

    <div class="bg-white rounded-2xl border border-gray-200 p-8 sm:p-12">
        <div class="text-center mb-10">
            <div class="w-16 h-16 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="truck" class="w-8 h-8 text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-brand-charcoal mb-2">شرایط ارسال و بازگشت کالا</h1>
            <p class="text-gray-500">راهنمای کامل ارسال سفارش‌ها و شرایط بازگشت کالا</p>
        </div>

        {{-- Shipping Methods --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-brand-charcoal mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۱</span>
                روش‌های ارسال
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="border border-gray-200 rounded-xl p-5 text-center hover:border-brand-red/30 transition">
                    <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="zap" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-brand-charcoal mb-1">ارسال سریع</h3>
                    <p class="text-sm text-gray-500">۱ تا ۲ روز کاری</p>
                    <p class="text-sm text-gray-400 mt-2">برای شهر تهران</p>
                </div>
                <div class="border border-gray-200 rounded-xl p-5 text-center hover:border-brand-red/30 transition">
                    <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="truck" class="w-6 h-6 text-amber-600"></i>
                    </div>
                    <h3 class="font-bold text-brand-charcoal mb-1">پست پیشتاز</h3>
                    <p class="text-sm text-gray-500">۳ تا ۵ روز کاری</p>
                    <p class="text-sm text-gray-400 mt-2">سراسر کشور</p>
                </div>
                <div class="border border-gray-200 rounded-xl p-5 text-center hover:border-brand-red/30 transition">
                    <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="map-pin" class="w-6 h-6 text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-brand-charcoal mb-1">پیک موتوری</h3>
                    <p class="text-sm text-gray-500">همان روز</p>
                    <p class="text-sm text-gray-400 mt-2">محدوده تهران</p>
                </div>
            </div>
        </div>

        {{-- Shipping Costs --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-brand-charcoal mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۲</span>
                هزینه ارسال
            </h2>
            <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">خرید بالای ۵۰۰٬۰۰۰ تومان</span>
                    <span class="font-bold text-green-600">رایگان</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">ارسال سریع (تهران)</span>
                    <span class="font-bold text-brand-charcoal font-num">۵۰٬۰۰۰ تومان</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">پست پیشتاز (سراسر کشور)</span>
                    <span class="font-bold text-brand-charcoal font-num">۳۵٬۰۰۰ تومان</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-600">پیک موتوری (تهران)</span>
                    <span class="font-bold text-brand-charcoal font-num">۴۵٬۰۰۰ تومان</span>
                </div>
            </div>
        </div>

        {{-- Return Policy --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-brand-charcoal mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۳</span>
                شرایط بازگشت کالا
            </h2>
            <div class="space-y-4 text-gray-600">
                <div class="flex items-start gap-3 p-4 bg-red-50 rounded-lg border border-red-100">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
                    <p class="text-sm">مهلت بازگشت کالا <strong>۷ روز</strong> پس از تحویل است. کالا باید در بسته‌بندی اصلی و بدون استفاده باشد.</p>
                </div>

                <ul class="space-y-3 mr-6 list-disc">
                    <li>کالا باید در وضعیت اولیه و بدون آسیب‌دیدگی باشد.</li>
                    <li>برچسب‌ها و هولوگرام‌های اصالت کالا نباید کنده شده باشند.</li>
                    <li>فاکتور خرید باید همراه کالا ارسال شود.</li>
                    <li>کالاهای مصرفی (روغن، لنت استفاده‌شده و...) قابل بازگشت نیستند.</li>
                    <li>هزینه ارسال کالای مرجوعی در صورت تأیید نقص، بر عهده لنگر موتور است.</li>
                </ul>
            </div>
        </div>

        {{-- Return Steps --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-brand-charcoal mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۴</span>
                مراحل بازگشت کالا
            </h2>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-brand-red text-white flex items-center justify-center text-sm font-bold shrink-0">۱</div>
                    <div>
                        <h4 class="font-medium text-brand-charcoal">ثبت درخواست</h4>
                        <p class="text-sm text-gray-500 mt-1">از طریق پنل کاربری یا تماس تلفنی، درخواست بازگشت خود را ثبت کنید.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-brand-red text-white flex items-center justify-center text-sm font-bold shrink-0">۲</div>
                    <div>
                        <h4 class="font-medium text-brand-charcoal">بررسی توسط تیم</h4>
                        <p class="text-sm text-gray-500 mt-1">درخواست شما ظرف ۲۴ ساعت کاری بررسی و نتیجه اعلام می‌شود.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-brand-red text-white flex items-center justify-center text-sm font-bold shrink-0">۳</div>
                    <div>
                        <h4 class="font-medium text-brand-charcoal">ارسال کالا</h4>
                        <p class="text-sm text-gray-500 mt-1">پس از تأیید، کالا را از طریق پست پیشتاز برای ما ارسال کنید.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-brand-red text-white flex items-center justify-center text-sm font-bold shrink-0">۴</div>
                    <div>
                        <h4 class="font-medium text-brand-charcoal">بازپرداخت</h4>
                        <p class="text-sm text-gray-500 mt-1">پس از دریافت و بررسی کالا، مبلغ ظرف ۷۲ ساعت به حساب شما بازگردانده می‌شود.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center pt-6 border-t border-gray-200">
            <p class="text-gray-500 mb-4">سوالی درباره ارسال یا بازگشت دارید؟</p>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                <span>تماس با پشتیبانی</span>
            </a>
        </div>
    </div>
</div>
@endsection
