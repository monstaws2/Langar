@extends('layouts.app')

@section('title', 'سوالات متداول')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium">سوالات متداول</span>
    </nav>

    <div class="text-center mb-10">
        <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="help-circle" class="w-8 h-8 text-amber-600"></i>
        </div>
        <h1 class="text-3xl font-bold text-brand-charcoal mb-2">سوالات متداول</h1>
        <p class="text-gray-500">پاسخ به پرتکرارترین سوالات شما</p>
    </div>

    <div class="space-y-4" x-data="{ openItem: null }">

        {{-- Orders & Purchase --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-brand-charcoal flex items-center gap-2">
                    <i data-lucide="shopping-bag" class="w-5 h-5 text-brand-red"></i>
                    سفارش و خرید
                </h2>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $faqs = [
                        [
                            'q' => 'چگونه می‌توانم سفارش ثبت کنم؟',
                            'a' => 'برای ثبت سفارش، ابتدا محصول مورد نظر خود را به سبد خرید اضافه کنید، سپس به صفحه سبد خرید بروید و پس از بررسی موارد، روی "ثبت سفارش" کلیک کنید. در صفحه بعد، اطلاعات ارسال را وارد کرده و سفارش خود را نهایی کنید.'
                        ],
                        [
                            'q' => 'آیا می‌توانم بدون ثبت‌نام سفارش دهم؟',
                            'a' => 'بله، امکان خرید مهمان بدون ثبت‌نام وجود دارد. اما برای دسترسی به تاریخچه سفارش‌ها و استفاده از خدمات بعدی، توصیه می‌کنیم حساب کاربری ایجاد کنید.'
                        ],
                        [
                            'q' => 'چگونه وضعیت سفارش خود را پیگیری کنم؟',
                            'a' => 'اگر حساب کاربری دارید، از منوی «حساب کاربری» وارد بخش «سفارش‌های من» شوید. در آنجا می‌توانید وضعیت تمام سفارش‌های خود را به صورت لحظه‌ای مشاهده کنید.'
                        ],
                        [
                            'q' => 'آیا امکان لغو سفارش وجود دارد؟',
                            'a' => 'بله، سفارش‌هایی که هنوز ارسال نشده‌اند قابل لغو هستند. برای لغو سفارش با پشتیبانی تماس بگیرید.'
                        ],
                    ];
                @endphp
                @foreach($faqs as $index => $faq)
                    <div>
                        <button @click="openItem === {{ $index }} ? openItem = null : openItem = {{ $index }}" class="w-full flex items-center justify-between px-6 py-4 text-right hover:bg-gray-50 transition">
                            <span class="font-medium text-brand-charcoal text-sm">{{ $faq['q'] }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform" :class="openItem === {{ $index }} ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="openItem === {{ $index }}" x-cloak x-transition class="px-6 pb-4">
                            <p class="text-sm text-gray-600 leading-relaxed pr-6 border-r-2 border-brand-red/20">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Shipping --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-brand-charcoal flex items-center gap-2">
                    <i data-lucide="truck" class="w-5 h-5 text-brand-red"></i>
                    ارسال و تحویل
                </h2>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $shippingFaqs = [
                        [
                            'q' => 'زمان ارسال سفارش‌ها چقدر است؟',
                            'a' => 'سفارش‌های تهران ۱ تا ۲ روز کاری و سفارش‌های شهرستان ۳ تا ۵ روز کاری پس از ثبت سفارش ارسال می‌شوند.'
                        ],
                        [
                            'q' => 'آیا ارسال رایگان دارید؟',
                            'a' => 'بله! برای خریدهای بالای ۵۰۰٬۰۰۰ تومان، ارسال به سراسر کشور رایگان است.'
                        ],
                        [
                            'q' => 'آیا می‌توانم سفارش را حضوری تحویل بگیرم؟',
                            'a' => 'در حال حاضر فقط ارسال پستی و پیک موتوری فعال است. امکان تحویل حضوری فعلاً وجود ندارد.'
                        ],
                    ];
                @endphp
                @foreach($shippingFaqs as $index => $faq)
                    @php $offset = 100 + $index; @endphp
                    <div>
                        <button @click="openItem === {{ $offset }} ? openItem = null : openItem = {{ $offset }}" class="w-full flex items-center justify-between px-6 py-4 text-right hover:bg-gray-50 transition">
                            <span class="font-medium text-brand-charcoal text-sm">{{ $faq['q'] }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform" :class="openItem === {{ $offset }} ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="openItem === {{ $offset }}" x-cloak x-transition class="px-6 pb-4">
                            <p class="text-sm text-gray-600 leading-relaxed pr-6 border-r-2 border-brand-red/20">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Payment --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-brand-charcoal flex items-center gap-2">
                    <i data-lucide="credit-card" class="w-5 h-5 text-brand-red"></i>
                    پرداخت
                </h2>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $paymentFaqs = [
                        [
                            'q' => 'روش‌های پرداخت چیست؟',
                            'a' => 'در حال حاضر پرداخت آنلاین از طریق درگاه‌های بانکی معتبر و پرداخت در محل (فقط تهران) امکان‌پذیر است.'
                        ],
                        [
                            'q' => 'آیا پرداخت اینترنتی امن است؟',
                            'a' => 'بله، تمامی تراکنش‌ها از طریق درگاه‌های بانکی معتبر با پروتکل SSL رمزنگاری شده انجام می‌شوند و خانه‌ی موتور به هیچ وجه به اطلاعات کارت بانکی شما دسترسی ندارد.'
                        ],
                        [
                            'q' => 'آیا امکان پرداخت اقساطی وجود دارد؟',
                            'a' => 'در حال حاضر امکان پرداخت اقساطی فعال نیست. در حال رایزنی با بانک‌ها برای ارائه این خدمت هستیم.'
                        ],
                    ];
                @endphp
                @foreach($paymentFaqs as $index => $faq)
                    @php $offset = 200 + $index; @endphp
                    <div>
                        <button @click="openItem === {{ $offset }} ? openItem = null : openItem = {{ $offset }}" class="w-full flex items-center justify-between px-6 py-4 text-right hover:bg-gray-50 transition">
                            <span class="font-medium text-brand-charcoal text-sm">{{ $faq['q'] }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform" :class="openItem === {{ $offset }} ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="openItem === {{ $offset }}" x-cloak x-transition class="px-6 pb-4">
                            <p class="text-sm text-gray-600 leading-relaxed pr-6 border-r-2 border-brand-red/20">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Returns --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-brand-charcoal flex items-center gap-2">
                    <i data-lucide="refresh-ccw" class="w-5 h-5 text-brand-red"></i>
                    بازگشت کالا
                </h2>
            </div>
            <div class="divide-y divide-gray-100">
                @php
                    $returnFaqs = [
                        [
                            'q' => 'مهلت بازگشت کالا چقدر است؟',
                            'a' => 'شما ۷ روز فرصت دارید تا در صورت عدم رضایت، کالا را بازگردانید. کالا باید در بسته‌بندی اصلی و بدون استفاده باشد.'
                        ],
                        [
                            'q' => 'چگونه درخواست بازگشت کالا دهم؟',
                            'a' => 'از طریق پنل کاربری و بخش «سفارش‌های من» یا تماس با پشتیبانی، درخواست بازگشت خود را ثبت کنید. تیم ما ظرف ۲۴ ساعت کاری درخواست شما را بررسی می‌کند.'
                        ],
                        [
                            'q' => 'چه کالاهایی قابل بازگشت نیستند؟',
                            'a' => 'کالاهای مصرفی مانند روغن موتور، لنت‌های استفاده‌شده، قطعاتی که نصب شده‌اند، و کالاهای فاقد بسته‌بندی اصلی قابل بازگشت نیستند.'
                        ],
                    ];
                @endphp
                @foreach($returnFaqs as $index => $faq)
                    @php $offset = 300 + $index; @endphp
                    <div>
                        <button @click="openItem === {{ $offset }} ? openItem = null : openItem = {{ $offset }}" class="w-full flex items-center justify-between px-6 py-4 text-right hover:bg-gray-50 transition">
                            <span class="font-medium text-brand-charcoal text-sm">{{ $faq['q'] }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 shrink-0 transition-transform" :class="openItem === {{ $offset }} ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="openItem === {{ $offset }}" x-cloak x-transition class="px-6 pb-4">
                            <p class="text-sm text-gray-600 leading-relaxed pr-6 border-r-2 border-brand-red/20">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Contact CTA --}}
    <div class="mt-10 bg-brand-charcoal rounded-2xl p-8 text-center">
        <h3 class="text-xl font-bold text-white mb-2">هنوز سوال دارید؟</h3>
        <p class="text-gray-400 mb-6">تیم پشتیبانی خانه‌ی موتور آماده پاسخگویی به شماست</p>
        <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 bg-brand-red text-white hover:bg-red-700 px-6 py-3 rounded-lg transition">
            <i data-lucide="message-circle" class="w-5 h-5"></i>
            <span>تماس با پشتیبانی</span>
        </a>
    </div>
</div>
@endsection
