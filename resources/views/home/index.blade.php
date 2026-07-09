@extends('layouts.app')

@section('title', 'قطعات یدکی موتورسیکلت | لنگرود، گیلان')
@section('meta_description', 'خانه‌ی موتور — فروشگاه تخصصی قطعات یدکی موتورسیکلت هوندا، یاماها، سوزوکی و کاوازاکی در لنگرود. ضمانت اصالت کالا، ارسال سریع به سراسر ایران. هر روز ۹ صبح تا ۹ شب.')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Hero -->
        <div class="bg-brand-charcoal rounded-2xl p-6 sm:p-10 mb-8 relative overflow-hidden" id="hero-section">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-red/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-brand-red/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-center sm:text-right">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight mb-3">
                        قطعات اصل موتورسیکلت
                    </h1>
                    <p class="text-gray-400 text-lg mb-6 max-w-lg">
                        تامین قطعات یدکی با ضمانت اصالت برای هوندا، یاماها، سوزوکی و کاوازاکی
                    </p>
                    <div class="flex flex-wrap gap-3 justify-center sm:justify-start">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-red hover:bg-red-700 text-white rounded-xl font-bold transition">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                            مشاهده محصولات
                        </a>
                        <a href="{{ route('brands.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-white/20 text-white hover:bg-white/10 rounded-xl font-medium transition">
                            <i data-lucide="tags" class="w-5 h-5"></i>
                            برندها
                        </a>
                    </div>
                </div>
                <div class="hidden md:block w-72 h-72">
                    <svg viewBox="0 0 400 400" class="w-full h-full">
                        <circle cx="200" cy="200" r="150" fill="none" stroke="#C0392B" stroke-width="2" opacity="0.3">
                            <animate attributeName="r" values="150;160;150" dur="4s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="200" cy="200" r="120" fill="none" stroke="#E67E22" stroke-width="2" opacity="0.4">
                            <animate attributeName="r" values="120;130;120" dur="3s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="200" cy="200" r="90" fill="#C0392B" opacity="0.1"/>
                        <circle cx="140" cy="160" r="8" fill="#C0392B" opacity="0.6">
                            <animate attributeName="cy" values="160;140;160" dur="2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="260" cy="240" r="6" fill="#E67E22" opacity="0.6">
                            <animate attributeName="cy" values="240;260;240" dur="2.5s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="200" cy="120" r="5" fill="#C0392B" opacity="0.5">
                            <animate attributeName="cx" values="200;220;200" dur="3s" repeatCount="indefinite"/>
                        </circle>
                        <rect x="170" y="170" width="60" height="60" rx="12" fill="#C0392B" opacity="0.9"/>
                        <rect x="185" y="185" width="30" height="30" rx="6" fill="#1A1A1A"/>
                        <circle cx="200" cy="200" r="8" fill="#E67E22"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-extrabold text-brand-charcoal">دسته‌بندی‌ها</h2>
                <a href="{{ route('products.index') }}" class="text-sm text-brand-red hover:underline flex items-center gap-1">
                    مشاهده همه
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3" id="categories-grid">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="bg-white border border-gray-200 hover:border-brand-red/30 hover:shadow-md rounded-xl p-4 flex flex-col items-center gap-3 transition group" data-card>
                        <span class="w-12 h-12 rounded-lg bg-gray-100 group-hover:bg-brand-red/10 flex items-center justify-center transition">
                            <i data-lucide="{{ $category->icon }}" class="w-6 h-6 text-gray-400 group-hover:text-brand-red transition"></i>
                        </span>
                        <span class="text-sm font-medium text-brand-charcoal text-center">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Latest Products -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-extrabold text-brand-charcoal">جدیدترین محصولات</h2>
                <a href="{{ route('products.index') }}" class="text-sm text-brand-red hover:underline flex items-center gap-1">
                    مشاهده همه
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4" id="latest-products-grid">
                @foreach($latestProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>

        <!-- Brands -->
        @if($brands->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-extrabold text-brand-charcoal">برندهای معتبر</h2>
                <a href="{{ route('brands.index') }}" class="text-sm text-brand-red hover:underline flex items-center gap-1">
                    مشاهده همه
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="brands-grid">
                @foreach($brands as $brand)
                    <a href="{{ route('brands.show', $brand->slug) }}" class="bg-white border border-gray-200 hover:border-brand-red/30 hover:shadow-md rounded-xl p-5 flex items-center justify-center gap-3 transition group" data-card>
                        <i data-lucide="bike" class="w-6 h-6 text-gray-300 group-hover:text-brand-red transition"></i>
                        <span class="font-bold text-brand-charcoal">{{ $brand->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Trust Badges -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="trust-badges">
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-3" data-card>
                <span class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                    <i data-lucide="badge-check" class="w-5 h-5 text-green-600"></i>
                </span>
                <div>
                    <p class="font-bold text-brand-charcoal text-sm">ضمانت اصالت</p>
                    <p class="text-xs text-gray-400">تمام قطعات اصل</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-3" data-card>
                <span class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <i data-lucide="truck" class="w-5 h-5 text-blue-600"></i>
                </span>
                <div>
                    <p class="font-bold text-brand-charcoal text-sm">ارسال سریع</p>
                    <p class="text-xs text-gray-400">به سراسر کشور</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-3" data-card>
                <span class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                    <i data-lucide="rotate-ccw" class="w-5 h-5 text-amber-600"></i>
                </span>
                <div>
                    <p class="font-bold text-brand-charcoal text-sm">۷ روز ضمانت بازگشت</p>
                    <p class="text-xs text-gray-400">بازگشت بدون قید و شرط</p>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-5 flex items-center gap-3" data-card>
                <span class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                    <i data-lucide="headphones" class="w-5 h-5 text-purple-600"></i>
                </span>
                <div>
                    <p class="font-bold text-brand-charcoal text-sm">پشتیبانی هر روز</p>
                    <p class="text-xs text-gray-400">۹ صبح تا ۹ شب</p>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.renderIcons();
            if (typeof anime === 'undefined') return;

            // Hero entrance
            anime({
                targets: '#hero-section > div > div:first-child > *',
                translateY: [30, 0],
                opacity: [0, 1],
                delay: anime.stagger(100, { start: 100 }),
                duration: 800,
                easing: 'easeOutCubic'
            });

            // Category cards
            anime({
                targets: '#categories-grid [data-card]',
                translateY: [20, 0],
                opacity: [0, 1],
                delay: anime.stagger(60, { start: 200 }),
                duration: 600,
                easing: 'easeOutCubic'
            });

            // Latest products
            anime({
                targets: '#latest-products-grid [data-card]',
                translateY: [20, 0],
                opacity: [0, 1],
                delay: anime.stagger(80, { start: 300 }),
                duration: 640,
                easing: 'easeOutCubic'
            });

            // Brands
            anime({
                targets: '#brands-grid [data-card]',
                translateY: [16, 0],
                opacity: [0, 1],
                delay: anime.stagger(70, { start: 400 }),
                duration: 600,
                easing: 'easeOutCubic'
            });

            // Trust badges
            anime({
                targets: '#trust-badges [data-card]',
                translateY: [12, 0],
                opacity: [0, 1],
                delay: anime.stagger(80, { start: 500 }),
                duration: 560,
                easing: 'easeOutCubic'
            });
        });
    </script>
@endpush
@endsection
