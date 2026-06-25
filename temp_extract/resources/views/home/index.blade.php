@extends('layouts.app')

@section('content')
    <!-- Category nav strip -->
    @if($categories->count())
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 overflow-x-auto no-scrollbar py-3">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="shrink-0 inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm text-brand-charcoal hover:border-brand-red hover:text-brand-red transition">
                        <i data-lucide="{{ $category->icon ?? 'tag' }}" class="w-4 h-4"></i>
                        <span class="whitespace-nowrap">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Hero banner -->
    <section class="bg-gradient-to-b from-brand-charcoal to-brand-charcoal-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-8 items-center py-12 lg:py-16">
            <!-- Copy (right side in RTL) -->
            <div class="text-right order-2 lg:order-1" id="hero-copy">
                <span class="inline-flex items-center gap-2 bg-brand-orange/15 text-brand-orange text-sm rounded-full px-4 py-1.5 mb-6">
                    <i data-lucide="flame" class="w-4 h-4"></i>
                    بهترین قیمت‌های بازار
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight text-balance">
                    قطعات اصلی موتور
                    <span class="block text-brand-red mt-2">هوندا</span>
                </h1>
                <p class="text-gray-300 text-lg mt-6 leading-relaxed max-w-lg">
                    اصیل‌ترین قطعات یدکی با بهترین قیمت، ارسال سریع به سراسر ایران و ضمانت اصالت کالا.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg text-lg font-bold transition">
                        مشاهده محصولات
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </a>
                    <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-white/30 text-white rounded-lg text-lg hover:bg-white hover:text-brand-charcoal transition">
                        تماس با ما
                    </a>
                </div>
            </div>

            <!-- Visual (left side in RTL) -->
            <div class="order-1 lg:order-2" id="hero-visual">
                <img src="{{ asset('images/hero-moto.png') }}" alt="موتورسیکلت هوندا و قطعات یدکی" class="w-full max-w-lg mx-auto rounded-2xl" loading="eager">
            </div>
        </div>
    </section>

    <!-- Trust badges row -->
    <section class="bg-brand-red">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-white">
                <div class="flex items-center justify-center gap-3">
                    <i data-lucide="truck" class="w-7 h-7 shrink-0"></i>
                    <span class="font-bold">ارسال سریع به سراسر ایران</span>
                </div>
                <div class="flex items-center justify-center gap-3 sm:border-x border-white/20">
                    <i data-lucide="shield-check" class="w-7 h-7 shrink-0"></i>
                    <span class="font-bold">ضمانت اصالت کالا</span>
                </div>
                <div class="flex items-center justify-center gap-3">
                    <i data-lucide="headphones" class="w-7 h-7 shrink-0"></i>
                    <span class="font-bold">پشتیبانی ۲۴ ساعته</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured products -->
    <section class="py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div class="text-right">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-charcoal">محصولات ویژه</h2>
                    <p class="text-gray-500 mt-1">پرفروش‌ترین قطعات این هفته</p>
                </div>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-red hover:text-brand-red-dark transition">
                    مشاهده همه
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
            </div>

            @if($products->count())
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6" id="home-featured-products">
                    @foreach($products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-12 text-center text-gray-500">
                    <i data-lucide="package-open" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                    هنوز محصولی ثبت نشده است.
                </div>
            @endif
        </div>
    </section>

    <!-- Brand strip -->
    @if($brands->count())
    <section class="py-12 bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-center text-xl font-bold text-brand-charcoal mb-8">برندهای معتبر همکار</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($brands as $brand)
                    <a href="{{ route('brands.show', $brand->slug) }}"
                       class="flex flex-col items-center justify-center gap-2 rounded-xl border border-gray-100 bg-brand-offwhite py-6 hover:border-brand-red hover:shadow-md transition">
                        <i data-lucide="bike" class="w-8 h-8 text-brand-charcoal/60"></i>
                        <span class="font-num font-bold uppercase tracking-widest text-brand-charcoal text-sm">{{ $brand->slug }}</span>
                        <span class="text-xs text-gray-500">{{ $brand->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Why choose us -->
    <section class="py-14 bg-brand-offwhite">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-brand-charcoal mb-10">چرا لنگر موتور؟</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-8 text-center">
                    <div class="w-16 h-16 bg-brand-red/10 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="badge-check" class="w-8 h-8 text-brand-red"></i>
                    </div>
                    <h4 class="font-bold mt-4 text-brand-charcoal">قطعات ۱۰۰٪ اصل</h4>
                    <p class="text-gray-500 mt-2 leading-relaxed">تمامی محصولات دارای تاییدیه اصالت از برندهای معتبر هستند.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-8 text-center">
                    <div class="w-16 h-16 bg-brand-orange/10 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="truck" class="w-8 h-8 text-brand-orange"></i>
                    </div>
                    <h4 class="font-bold mt-4 text-brand-charcoal">ارسال سریع</h4>
                    <p class="text-gray-500 mt-2 leading-relaxed">ارسال به سراسر ایران از طریق پست پیشتاز و تیپاکس در کمترین زمان.</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-8 text-center">
                    <div class="w-16 h-16 bg-brand-red/10 rounded-full flex items-center justify-center mx-auto">
                        <i data-lucide="headphones" class="w-8 h-8 text-brand-red"></i>
                    </div>
                    <h4 class="font-bold mt-4 text-brand-charcoal">پشتیبانی ۲۴ ساعته</h4>
                    <p class="text-gray-500 mt-2 leading-relaxed">تیم پشتیبانی ما آماده پاسخگویی به تمام سوالات شما است.</p>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.renderIcons) window.renderIcons();
                if (typeof anime === 'undefined') return;

                var heroCopy = document.getElementById('hero-copy');
                if (heroCopy) {
                    anime({
                        targets: heroCopy.children,
                        translateX: [40, 0],
                        opacity: [0, 1],
                        delay: anime.stagger(100),
                        duration: 800,
                        easing: 'easeOutCubic'
                    });
                }

                var heroVisual = document.getElementById('hero-visual');
                if (heroVisual) {
                    anime({
                        targets: heroVisual,
                        translateX: [-24, 0],
                        opacity: [0, 1],
                        scale: [0.98, 1],
                        duration: 900,
                        easing: 'easeOutCubic',
                        delay: 150
                    });
                }

                anime({
                    targets: '#home-featured-products [data-card]',
                    translateY: [18, 0],
                    opacity: [0, 1],
                    delay: anime.stagger(80, { start: 120 }),
                    duration: 650,
                    easing: 'easeOutCubic'
                });
            });
        </script>
    @endpush
@endsection
