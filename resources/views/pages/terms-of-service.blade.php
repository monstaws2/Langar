@extends('layouts.app')

@section('title', 'شرایط استفاده')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">شرایط استفاده</span>
    </nav>

    <div class="bg-white rounded-2xl border border-gray-200 p-8 sm:p-12">
        <div class="text-center mb-10">
            <div class="w-16 h-16 rounded-full bg-purple-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="file-text" class="w-8 h-8 text-purple-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-brand-charcoal mb-2">شرایط و مقررات استفاده</h1>
            <p class="text-gray-500">آخرین به‌روزرسانی: ۱۴۰۳/۰۴/۰۱</p>
        </div>

        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6">
            <p>
                با دسترسی و استفاده از فروشگاه اینترنتی خانه‌ی موتور، شما موافقت خود را با این شرایط و مقررات اعلام می‌کنید. لطفاً قبل از استفاده از خدمات سایت، این صفحه را به دقت مطالعه فرمایید.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۱</span>
                تعاریف
            </h2>
            <ul class="space-y-2 mr-6 list-disc">
                <li><strong>«خانه‌ی موتور»</strong> یا <strong>«ما»</strong>: به فروشگاه اینترنتی خانه‌ی موتور و تیم مدیریتی آن اشاره دارد.</li>
                <li><strong>«کاربر»</strong> یا <strong>«شما»</strong>: به هر شخصی که از سایت بازدید یا خرید می‌کند، اشاره دارد.</li>
                <li><strong>«محصول»</strong>: به کالاهای عرضه‌شده در فروشگاه اشاره دارد.</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۲</span>
                ثبت‌نام و حساب کاربری
            </h2>
            <ul class="space-y-2 mr-6 list-disc">
                <li>برای ثبت سفارش، نیاز به ایجاد حساب کاربری است.</li>
                <li>اطلاعات وارد شده باید دقیق، صحیح و به‌روز باشند.</li>
                <li>مسئولیت حفظ رمز عبور بر عهده کاربر است.</li>
                <li>در صورت مشاهوه هرگونه استفاده غیرمجاز از حساب کاربری، باید فوراً به ما اطلاع دهید.</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۳</span>
                قیمت‌گذاری و پرداخت
            </h2>
            <ul class="space-y-2 mr-6 list-disc">
                <li>تمام قیمت‌ها به تومان و شامل مالیات بر ارزش افزوده است.</li>
                <li>قیمت‌ها ممکن است بدون اطلاع‌رسانی قبلی تغییر کنند.</li>
                <li>مبلغ نهایی سفارش در صفحه تأیید سفارش مشخص می‌شود.</li>
                <li>پرداخت از طریق درگاه‌های امن بانکی انجام می‌شود.</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۴</span>
                ثبت و ارسال سفارش
            </h2>
            <ul class="space-y-2 mr-6 list-disc">
                <li>ثبت سفارش به معنای پذیرش این شرایط است.</li>
                <li>زمان تحویل بسته به مقصد و نوع ارسال متفاوت است.</li>
                <li>ما حق لغو سفارش در صورت موجود نبودن کالا را برای خود محفوظ می‌داریم.</li>
                <li>در صورت لغو سفارش، مبلغ پرداخت‌شده ظرف ۷۲ ساعت بازگردانده می‌شود.</li>
            </ul>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۵</span>
                ضمانت و بازگشت کالا
            </h2>
            <p>
                تمامی محصولات خانه‌ی موتور دارای ضمانت اصالت کالا هستند. در صورت عدم رضایت، امکان بازگشت کالا طبق شرایط صفحه <a href="{{ route('shipping-returns') }}" class="text-brand-red hover:underline">شرایط ارسال و بازگشت</a> وجود دارد.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۶</span>
                محدودیت مسئولیت
            </h2>
            <p>
                خانه‌ی موتور تلاش می‌کند اطلاعات دقیق و به‌روز در سایت ارائه دهد، اما مسئولیت استفاده صحیح از محصولات بر عهده خریدار است. ما در قبال خسارات ناشی از استفاده نادرست از محصولات مسئولیتی نداریم.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۷</span>
                تغییرات شرایط
            </h2>
            <p>
                ما حق تغییر این شرایط را در هر زمان برای خود محفوظ می‌داریم. تغییرات پس از انتشار در همین صفحه لازم‌الاجراست. ادامه استفاده شما از سایت به معنای پذیرش شرایط به‌روزشده است.
            </p>

            <h2 class="text-xl font-bold text-brand-charcoal mt-8 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-brand-red/10 flex items-center justify-center text-brand-red text-sm font-bold">۸</span>
                تماس با ما
            </h2>
            <p>
                برای هرگونه سوال یا ابهام، از طریق صفحه <a href="{{ route('contact.index') }}" class="text-brand-red hover:underline">تماس با ما</a> با ما در ارتباط باشید.
            </p>
        </div>
    </div>
</div>
@endsection
