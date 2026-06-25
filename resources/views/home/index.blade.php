@extends('layouts.app')

@section('content')
    <!-- Section 1 — Hero Banner -->
    <!-- Hero (redesigned) -->
    <section class="w-full" style="background: linear-gradient(180deg,#1A1A1A 0%,#2C2C2C 100%); min-height: 90vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center justify-center h-full">
            <!-- RIGHT: Text -->
            <div class="w-full lg:w-7/12 text-right py-12" id="hero-copy">
                <span class="inline-block bg-[#E67E22] text-white text-sm rounded-full px-4 py-1 mb-6">🔥 بهترین قیمت‌های بازار</span>
                <h1 class="text-5xl font-extrabold text-white leading-tight">قطعات یدکی<br><span class="text-[#C0392B]">موتورسیکلت هوندا</span></h1>
                <p class="text-gray-300 text-lg mt-6 leading-relaxed">اصیل‌ترین قطعات با بهترین قیمت | ارسال سریع به سراسر ایران | ضمانت اصالت کالا</p>

                <div class="mt-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <a href="{{ route('products.index') }}" class="px-8 py-4 bg-[#C0392B] text-white rounded-lg text-lg font-bold hover:opacity-90">مشاهده محصولات ←</a>
                    <a href="/contact" class="px-8 py-4 border-2 border-white text-white rounded-lg text-lg hover:bg-white hover:text-gray-900">تماس با ما</a>
                </div>

                <div class="mt-8 flex flex-wrap gap-6 text-gray-400 text-sm">
                    <div class="flex items-center gap-2">✅ <span>ضمانت اصالت</span></div>
                    <div class="flex items-center gap-2">🚚 <span>ارسال سریع</span></div>
                    <div class="flex items-center gap-2">🔧 <span>نصب رایگان</span></div>
                    <div class="flex items-center gap-2">📞 <span>پشتیبانی ۲۴/۷</span></div>
                </div>
            </div>

            <!-- LEFT: Visual -->
            <div class="w-full lg:w-5/12 flex items-center justify-center py-12" id="hero-visual">
                <div class="w-full max-w-md rounded-2xl border-2 border-red-800 bg-gray-800 flex flex-col items-center justify-center" style="height:400px;">
                    <div class="text-[4rem]">🏍️</div>
                    <div class="text-white font-bold mt-4">هوندا CG125</div>
                    <div class="text-gray-400 mt-2">قطعات اصل</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2 — Stats Bar -->
    <section class="w-full" style="background-color: #C0392B;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-white">
                <div class="flex flex-col items-center border-r border-red-700 md:border-r-0 md:border-r md:last:border-r-0">🏍️ <span class="font-bold mt-2">بیش از <span data-count-up="200">0</span> محصول</span></div>
                <div class="flex flex-col items-center border-r border-red-700 md:border-r-0 md:border-r md:last:border-r-0">🚚 <span class="font-bold mt-2">ارسال به سراسر ایران</span></div>
                <div class="flex flex-col items-center border-r border-red-700 md:border-r-0 md:border-r md:last:border-r-0">✅ <span class="font-bold mt-2">ضمانت اصالت کالا</span></div>
                <div class="flex flex-col items-center">⭐ <span class="font-bold mt-2">مشتریان راضی</span></div>
            </div>
        </div>
    </section>

    <!-- Section 3 — Categories -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-right mb-6">خرید بر اساس دسته‌بندی</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6" id="home-categories">
                @foreach($categories as $category)
                    <a href="/categories/{{ $category->id }}" class="group flex flex-col items-center justify-center bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all duration-300 border-2 border-transparent hover:border-red-500 cursor-pointer" data-card>
                        <span class="text-5xl mb-3 group-hover:scale-110 transition-transform duration-300">{!! $category->icon !!}</span>
                        <h3 class="font-bold text-gray-800 text-base text-center">{{ $category->name }}</h3>
                        <span class="text-xs text-gray-400 mt-1">مشاهده محصولات</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section 4 — Featured Products -->
    <section class="py-12" style="background-color: #F5F5F5;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-right">محصولات ویژه</h2>
                <a href="{{ route('products.index') }}" class="text-sm text-gray-600">مشاهده همه</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="home-featured-products">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition" data-card>
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="bg-gray-200 h-48 flex items-center justify-center">
                                <span class="text-gray-400 text-2xl">{{ strtoupper(substr($product->name,0,2)) }}</span>
                            </div>
                        </a>
                        <div class="p-4 text-right">
                            <div class="flex items-start justify-between">
                                <h3 class="text-md font-semibold text-right max-w-[85%]">{{ $product->name }}</h3>
                                <span class="bg-[#E67E22] text-xs text-white px-2 py-1 rounded">{{ $product->brand->name ?? '' }}</span>
                            </div>

                            <p class="text-[#C0392B] font-bold mt-3">{{ number_format($product->price) }} تومان</p>

                            @if($product->stock > 0)
                                <span class="text-sm text-green-600">موجود</span>
                            @else
                                <span class="text-sm text-red-600">ناموجود</span>
                            @endif

                            <button class="w-full mt-4 py-2 bg-[#E67E22] text-white rounded" data-add-to-cart>افزودن به سبد</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section 5 — Why Choose Us -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-[#1A1A1A] mb-8">چرا لنگر موتور؟</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 bg-white rounded-2xl shadow-sm hover:shadow-lg text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto text-4xl">🔧</div>
                    <h4 class="font-bold mt-4">قطعات ۱۰۰٪ اصل</h4>
                    <p class="text-gray-500 mt-2">تمامی محصولات دارای تاییدیه اصالت از برندهای معتبر هستند</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm hover:shadow-lg text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto text-4xl">🚚</div>
                    <h4 class="font-bold mt-4">ارسال سریع</h4>
                    <p class="text-gray-500 mt-2">ارسال به سراسر ایران از طریق پست پیشتاز و تیپاکس در کمترین زمان</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-sm hover:shadow-lg text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto text-4xl">📞</div>
                    <h4 class="font-bold mt-4">پشتیبانی ۲۴ ساعته</h4>
                    <p class="text-gray-500 mt-2">تیم پشتیبانی ما آماده پاسخگویی به تمام سوالات شما است</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full bg-[#1A1A1A] text-white">
        <div class="max-w-7xl mx-auto px-8 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-right">
                <div class="text-2xl font-bold" style="color: #C0392B;">لنگر موتور</div>
                <p class="text-gray-400 mt-2">فروشگاه تخصصی قطعات یدکی موتورسیکلت هوندا با بیش از ۲۰۰ محصول اصل</p>
                <div class="mt-4 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">📘</div>
                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">📸</div>
                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">💬</div>
                </div>
            </div>

            <div class="text-center">
                <h4 class="font-bold mb-2">دسترسی سریع</h4>
                <div class="flex flex-col items-center">
                    <a href="/" class="text-gray-400 hover:text-white text-sm py-1">خانه</a>
                    <a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white text-sm py-1">محصولات</a>
                    <a href="/brands" class="text-gray-400 hover:text-white text-sm py-1">برندها</a>
                    <a href="/about" class="text-gray-400 hover:text-white text-sm py-1">درباره ما</a>
                    <a href="/contact" class="text-gray-400 hover:text-white text-sm py-1">تماس با ما</a>
                </div>
            </div>

            <div class="text-left text-gray-400">
                <h4 class="font-bold mb-2">تماس با ما</h4>
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2"><span>📍</span> آدرس: ایران</div>
                    <div class="flex items-center gap-2"><span>📞</span> تلفن: ۰۲۱-XXXX-XXXX</div>
                    <div class="flex items-center gap-2"><span>✉️</span> ایمیل: info@langarmotor.ir</div>
                    <div class="flex items-center gap-2"><span>💬</span> واتساپ: ۰۹۱۲-XXX-XXXX</div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 py-4 text-center text-gray-500 text-sm">تمامی حقوق برای لنگر موتور محفوظ است © ۱۴۰۳</div>
    </footer>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof anime === 'undefined') {
                        return;
                    }

                    var heroCopy = document.getElementById('hero-copy');
                    var heroVisual = document.getElementById('hero-visual');

                    if (heroCopy) {
                        anime({
                            targets: heroCopy.children,
                            translateX: [42, 0],
                            opacity: [0, 1],
                            delay: anime.stagger(110),
                            duration: 900,
                            easing: 'easeOutCubic'
                        });
                    }

                    if (heroVisual) {
                        anime({
                            targets: heroVisual,
                            translateX: [-24, 0],
                            opacity: [0, 1],
                            scale: [0.98, 1],
                            duration: 950,
                            easing: 'easeOutCubic',
                            delay: 180
                        });
                    }

                    anime({
                        targets: '#home-categories [data-card], #home-featured-products [data-card]',
                        translateY: [18, 0],
                        opacity: [0, 1],
                        delay: anime.stagger(90, { start: 140 }),
                        duration: 700,
                        easing: 'easeOutCubic'
                    });

                    document.querySelectorAll('[data-count-up]').forEach(function (element) {
                        var targetValue = parseInt(element.getAttribute('data-count-up'), 10) || 0;
                        var state = { value: 0 };

                        anime({
                            targets: state,
                            value: targetValue,
                            duration: 1400,
                            easing: 'easeOutCubic',
                            update: function () {
                                element.textContent = Math.round(state.value).toLocaleString('fa-IR');
                            }
                        });
                    });

                    document.querySelectorAll('[data-add-to-cart]').forEach(function (button) {
                        button.addEventListener('click', function () {
                            anime({
                                targets: button,
                                scale: [1, 1.08, 1],
                                duration: 420,
                                easing: 'easeOutQuad'
                            });
                        });
                    });

                    var navbar = document.getElementById('site-navbar');
                    if (navbar) {
                        var lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        var navbarHidden = false;

                        window.addEventListener('scroll', function () {
                            var currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

                            if (currentScrollTop > lastScrollTop + 8 && currentScrollTop > 120 && !navbarHidden) {
                                navbarHidden = true;
                                anime({
                                    targets: navbar,
                                    translateY: ['0%', '-100%'],
                                    duration: 320,
                                    easing: 'easeOutCubic'
                                });
                            } else if (currentScrollTop < lastScrollTop - 8 && navbarHidden) {
                                navbarHidden = false;
                                anime({
                                    targets: navbar,
                                    translateY: ['-100%', '0%'],
                                    duration: 320,
                                    easing: 'easeOutCubic'
                                });
                            }

                            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
                        }, { passive: true });
                    }
                });
            </script>
        @endpush
    @endsection