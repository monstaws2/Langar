@extends('layouts.app')

@section('title', 'حریم خصوصی')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">حریم خصوصی</span>
    </nav>

    <div class="bg-white rounded-2xl border border-gray-200 p-8 sm:p-12">
        <div class="text-center mb-10">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shield-check" class="w-8 h-8 text-blue-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-brand-charcoal mb-2">حریم خصوصی</h1>
            <p class="text-gray-500">آخرین به‌روزرسانی: ۱۴۰۳/۰۴/۰۱</p>
        </div>

        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6">
            <p>
                فروشگاه لنگر موتور متعهد به حفظ حریم خصوصی کاربران است. این سیاست حریم خصوصی توضیح می‌دهد که ما چه اطلاعاتی را جمع‌آوری می‌کنیم، چگونه از آن‌ها استفاده می‌کنیم و چگونه از آن‌ها محافظت می‌کنیم.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۱</span>
                اطلاعاتی که جمع‌آوری می‌کنیم
            </h2>
            <p>ما ممکن است اطلاعات زیر را هنگام استفاده شما از سایت جمع‌آوری کنیم:</p>
            <ul class="space-y-2 mr-6 list-disc">
                <li>نام و نام خانوادگی</li>
                <li>آدرس ایمیل</li>
                <li>شماره تماس</li>
                <li>آدرس پستی و کد پستی</li>
                <li>اطلاعات دستگاه و مرورگر (IP، نوع مرورگر، سیستم‌عامل)</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۲</span>
                نحوه استفاده از اطلاعات
            </h2>
            <p>اطلاعات شما برای موارد زیر استفاده می‌شود:</p>
            <ul class="space-y-2 mr-6 list-disc">
                <li>پردازش و ارسال سفارش‌ها</li>
                <li>ارسال اطلاعیه‌ها و به‌روزرسانی‌های مربوط به سفارش</li>
                <li>پاسخ به درخواست‌ها و سوالات شما</li>
                <li>بهبود تجربه کاربری و کیفیت خدمات</li>
                <li>ارسال پیشنهادات ویژه (با رضایت شما)</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۳</span>
                حفاظت از اطلاعات
            </h2>
            <p>
                ما از اقدامات امنیتی فنی و سازمانی مناسب برای محافظت از اطلاعات شخصی شما در برابر دسترسی غیرمجاز، تغییر، افشا یا تخریب استفاده می‌کنیم. تمامی ارتباطات با سایت با پروتکل SSL رمزنگاری می‌شوند.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۴</span>
                اشتراک‌گذاری اطلاعات
            </h2>
            <p>
                ما اطلاعات شخصی شما را به هیچ شخص یا سازمان ثالثی نمی‌فروشیم. اطلاعات تنها در صورت الزام قانونی یا برای انجام خدمات لجستیک (ارسال سفارش) با شرکت‌های پستی و حمل‌ونقل در میان گذاشته می‌شود.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۵</span>
                کوکی‌ها
            </h2>
            <p>
                سایت لنگر موتور از کوکی‌ها برای ذخیره سبد خرید، بهبود تجربه کاربری و تحلیل ترافیک استفاده می‌کند. با ادامه استفاده از سایت، شما با استفاده از کوکی‌ها موافقت می‌کنید.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۶</span>
                حقوق شما
            </h2>
            <p>شما حق دارید:</p>
            <ul class="space-y-2 mr-6 list-disc">
                <li>به اطلاعات شخصی خود دسترسی داشته باشید</li>
                <li>اطلاعات نادرست را تصحیح کنید</li>
                <li>درخواست حذف اطلاعات خود را بدهید</li>
                <li>از دریافت ایمیل‌های تبلیغاتی انصراف دهید</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۷</span>
                تماس با ما
            </h2>
            <p>
                اگر سوالی درباره حریم خصوصی دارید، از طریق صفحه <a href="{{ route('contact.index') }}" class="text-brand-red hover:underline">تماس با ما</a> یا ایمیل info@langarmotor.ir با ما در ارتباط باشید.
            </p>
        </div>
    </div>
</div>
@endsection
