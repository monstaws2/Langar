@extends('layouts.app')

@section('title', $product->seoTitle())
@section('meta_description', $product->seoMetaDescription())

@push('meta')
    <link rel="canonical" href="{{ $product->seoCanonicalUrl() }}">
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->seoTitle() }}">
    <meta property="og:description" content="{{ $product->seoMetaDescription() }}">
    <meta property="og:url" content="{{ $product->seoCanonicalUrl() }}">
    @if($product->image)
        <meta property="og:image" content="{{ asset('storage/' . $product->image) }}">
    @endif
    @if($product->seoTagsList())
        <meta name="keywords" content="{{ $product->seoTagsList() }}">
    @endif
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-brand-red transition">خانه</a>
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <a href="{{ route('products.index') }}" class="hover:text-brand-red transition">محصولات</a>
        @if($product->category)
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
            <a href="{{ route('products.index', ['category' => $product->category->id]) }}" class="hover:text-brand-red transition">{{ $product->category->name }}</a>
        @endif
        <i data-lucide="chevron-left" class="w-4 h-4"></i>
        <span class="text-brand-charcoal font-medium truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="product-show-grid">
        <!-- Image -->
        <div class="md:col-span-1" data-product-panel>
            <div class="bg-white rounded-2xl border border-gray-200 h-80 sm:h-96 flex items-center justify-center relative overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                @else
                    <div class="flex flex-col items-center text-gray-300">
                        <i data-lucide="{{ $product->category->icon ?? 'package' }}" class="w-24 h-24 sm:w-28 sm:h-28"></i>
                        <span class="text-xs mt-2">{{ $product->category->name ?? 'محصول' }}</span>
                    </div>
                @endif

                @if($product->stock > 0 && $product->stock <= 5)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg">تنها {{ \App\Support\Format::digits($product->stock) }} عدد باقی‌مانده</span>
                @elseif($product->stock < 1)
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-gray-800/80 text-white text-xs font-bold rounded-lg">ناموجود</span>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-gray-200" data-product-panel>
            <div class="flex items-center gap-2 mb-3">
                @if($product->brand)
                    <span class="bg-brand-red/10 text-brand-red text-xs px-2.5 py-1 rounded-full font-medium">{{ $product->brand->name }}</span>
                @endif
                @if($product->category)
                    <span class="bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">{{ $product->category->name }}</span>
                @endif
            </div>

            <h1 class="text-2xl font-extrabold text-brand-charcoal leading-tight">{{ $product->name }}</h1>

            {{-- Inline rating summary --}}
            @if($averageRating)
                <div class="flex items-center gap-2 mt-2">
                    @include('partials.star-rating', ['rating' => $averageRating, 'size' => 'w-4 h-4'])
                    <span class="text-sm font-semibold text-amber-500 font-num">{{ \App\Support\Format::digits($averageRating) }}</span>
                    <span class="text-sm text-gray-400">({{ \App\Support\Format::digits($reviewsCount) }} نظر)</span>
                </div>
            @endif

            <div class="flex items-center gap-4 mt-4">
                <p class="text-3xl text-brand-red font-extrabold font-num">
                    {{ \App\Support\Format::price($product->price) }}
                    <span class="text-base font-normal text-gray-400">تومان</span>
                </p>
            </div>

            <div class="mt-3 flex items-center gap-4">
                @if($product->stock > 0)
                    <span class="inline-flex items-center gap-1.5 text-green-600 font-medium text-sm bg-green-50 px-3 py-1.5 rounded-lg">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        موجود در انبار ({{ \App\Support\Format::digits($product->stock) }} عدد)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-red-600 font-medium text-sm bg-red-50 px-3 py-1.5 rounded-lg">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        ناموجود
                    </span>
                @endif

                <span class="inline-flex items-center gap-1.5 text-blue-600 font-medium text-sm bg-blue-50 px-3 py-1.5 rounded-lg">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    ضمانت اصالت
                </span>
            </div>

            <hr class="my-6 border-gray-100">

            <div class="text-gray-600 leading-relaxed text-sm">
                {{ $product->description ?: 'توضیحات این محصول به‌زودی تکمیل می‌شود.' }}
            </div>

            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-6 flex flex-col sm:flex-row gap-3">
                @csrf
                <button type="submit" @disabled($product->stock < 1)
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3.5 bg-brand-red hover:bg-red-700 active:scale-95 text-white rounded-xl font-bold transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    @if($product->stock > 0)
                        افزودن به سبد خرید
                    @else
                        در حال حاضر ناموجود
                    @endif
                </button>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center gap-2 py-3.5 border-2 border-gray-200 text-gray-600 hover:border-brand-red hover:text-brand-red rounded-xl transition font-medium">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    مشاهده سبد خرید
                </a>
            </form>

            <div class="mt-6 grid grid-cols-3 gap-3">
                <div class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="badge-check" class="w-6 h-6 text-brand-red"></i>
                    <span class="text-xs text-gray-600 font-medium">ضمانت اصالت</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="truck" class="w-6 h-6 text-brand-red"></i>
                    <span class="text-xs text-gray-600 font-medium">ارسال سریع</span>
                </div>
                <div class="flex flex-col items-center gap-2 p-4 bg-gray-50 rounded-xl text-center">
                    <i data-lucide="rotate-ccw" class="w-6 h-6 text-brand-red"></i>
                    <span class="text-xs text-gray-600 font-medium">مرجوعی ۷ روزه</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================== -->
    <!--  REVIEWS SECTION                                                     -->
    <!-- ================================================================== -->
    <div class="mt-12" id="reviews-section">
        <h2 class="text-xl font-extrabold text-brand-charcoal mb-6 flex items-center gap-2">
            <i data-lucide="message-square" class="w-5 h-5 text-brand-red"></i>
            نظرات مشتریان
        </h2>

        {{-- Rating summary --}}
        @if($reviewsCount > 0)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                {{-- Big average --}}
                <div class="text-center shrink-0 min-w-[100px]">
                    <div class="text-5xl font-extrabold text-brand-charcoal font-num">{{ \App\Support\Format::digits($averageRating) }}</div>
                    <div class="mt-2">@include('partials.star-rating', ['rating' => $averageRating, 'size' => 'w-5 h-5'])</div>
                    <div class="text-xs text-gray-400 mt-1">از {{ \App\Support\Format::digits($reviewsCount) }} نظر</div>
                </div>
                {{-- Distribution bars --}}
                <div class="flex-1 w-full space-y-1.5">
                    @foreach($ratingDistribution as $stars => $data)
                    <div class="flex items-center gap-2 text-sm">
                        <span class="font-num text-gray-600 w-4 text-left shrink-0">{{ $stars }}</span>
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-amber-400 h-2 rounded-full transition-all duration-500" style="width: {{ $data['percent'] }}%"></div>
                        </div>
                        <span class="font-num text-gray-400 text-xs w-6 text-left shrink-0">{{ \App\Support\Format::digits($data['count']) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Approved reviews list --}}
        @if($reviews->count())
            <div class="space-y-4 mb-6">
                @foreach($reviews as $review)
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-brand-charcoal/10 flex items-center justify-center text-brand-charcoal font-bold text-sm shrink-0">
                                {{ mb_substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-brand-charcoal text-sm">{{ $review->user->name }}</div>
                                <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                    @include('partials.star-rating', ['rating' => $review->rating, 'size' => 'w-3.5 h-3.5'])
                                    @if($review->is_verified_purchase)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-green-700 bg-green-50 border border-green-200 px-1.5 py-0.5 rounded-full">
                                            <i data-lucide="shield-check" class="w-3 h-3"></i>خرید تأیید شده
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400 font-num shrink-0">{{ \App\Support\Format::digits($review->created_at->translatedFormat('j F Y')) }}</span>
                    </div>

                    @if($review->title)
                        <h4 class="font-bold text-brand-charcoal mt-3 text-sm">{{ $review->title }}</h4>
                    @endif
                    <p class="text-gray-600 text-sm leading-relaxed mt-2">{{ $review->body }}</p>

                    {{-- Admin reply --}}
                    @if($review->admin_reply)
                        <div class="mt-4 border-r-4 border-brand-red/40 bg-brand-red/5 rounded-xl p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i data-lucide="message-square" class="w-4 h-4 text-brand-red"></i>
                                <span class="text-xs font-bold text-brand-red">پاسخ فروشگاه</span>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $review->admin_reply }}</p>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($reviews->hasPages())
                <div class="flex justify-center">
                    {{ $reviews->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-400 mb-6">
                <i data-lucide="message-square" class="w-10 h-10 mx-auto mb-3 text-gray-300"></i>
                <p class="text-sm">هنوز نظری برای این محصول ثبت نشده است. اولین نفر باشید!</p>
            </div>
        @endif

        {{-- ============================================================== --}}
        {{--  REVIEW SUBMISSION FORM                                          --}}
        {{-- ============================================================== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 class="font-bold text-brand-charcoal text-base mb-5 flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4 text-brand-red"></i>
                ثبت نظر
            </h3>

            @auth
                @if($userReview)
                    {{-- Already reviewed --}}
                    <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-800">
                        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                        <div>
                            <div class="font-medium">نظر شما ثبت شده است.</div>
                            <div class="text-xs text-green-600 mt-0.5">
                                @if($userReview->is_approved)
                                    نظر شما تأیید شده و قابل مشاهده است.
                                @else
                                    نظر شما در انتظار تأیید مدیر است.
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($canReview)
                    {{-- Submission form --}}
                    @if($isVerifiedPurchaser)
                        <div class="inline-flex items-center gap-1.5 text-xs text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full mb-4">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                            شما این محصول را خریداری کرده‌اید. نظر شما با نشان «خرید تأیید شده» منتشر می‌شود.
                        </div>
                    @endif

                    <form action="{{ route('reviews.store', $product->slug) }}" method="POST" class="space-y-4" id="review-form">
                        @csrf

                        {{-- Star picker --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">امتیاز شما <span class="text-brand-red">*</span></label>
                            <div class="flex gap-1" id="star-picker" dir="ltr">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        data-star="{{ $i }}"
                                        class="star-btn w-9 h-9 text-gray-300 hover:text-amber-400 transition-colors duration-100 focus:outline-none"
                                        aria-label="{{ $i }} ستاره">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                            @error('rating')
                                <p class="text-xs text-brand-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div>
                            <label for="review-title" class="block text-sm font-medium text-gray-700 mb-1">عنوان نظر <span class="text-xs text-gray-400">(اختیاری)</span></label>
                            <input type="text" name="title" id="review-title" value="{{ old('title') }}"
                                maxlength="200"
                                placeholder="مثال: کیفیت عالی، ارزش خرید دارد"
                                class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all">
                            @error('title')
                                <p class="text-xs text-brand-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Body --}}
                        <div>
                            <label for="review-body" class="block text-sm font-medium text-gray-700 mb-1">متن نظر <span class="text-brand-red">*</span></label>
                            <textarea name="body" id="review-body" rows="4"
                                minlength="10" maxlength="2000"
                                placeholder="تجربه خود از این محصول را با دیگران به اشتراک بگذارید..."
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all resize-none">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="text-xs text-brand-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-red hover:bg-red-700 active:scale-95 text-white rounded-xl text-sm font-bold transition-all">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            ثبت نظر
                        </button>
                    </form>
                @endif
            @else
                {{-- Guest prompt --}}
                <div class="flex items-center gap-4 flex-col sm:flex-row bg-gray-50 border border-gray-200 rounded-xl px-5 py-4 text-sm">
                    <i data-lucide="log-in" class="w-8 h-8 text-gray-400 shrink-0"></i>
                    <div class="text-center sm:text-right">
                        <p class="font-medium text-brand-charcoal">برای ثبت نظر وارد حساب کاربری خود شوید</p>
                        <p class="text-gray-500 text-xs mt-0.5">نظرات کاربران به دیگر خریداران کمک می‌کند بهتر تصمیم بگیرند.</p>
                    </div>
                    <a href="{{ route('otp.request.form') }}" class="mr-auto shrink-0 inline-flex items-center gap-1.5 px-4 py-2 bg-brand-red text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        ورود / ثبت‌نام
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Related products -->
    @if($related->count())
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-extrabold text-brand-charcoal">محصولات مرتبط</h3>
            <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-sm text-brand-red hover:underline flex items-center gap-1">
                مشاهده همه
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4" id="related-products-grid">
            @foreach($related as $rProduct)
                @include('partials.product-card', ['product' => $rProduct])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (window.renderIcons) window.renderIcons();

    /* ---------- interactive star picker ---------- */
    const picker      = document.getElementById('star-picker');
    const ratingInput = document.getElementById('rating-input');
    if (picker) {
        const stars = picker.querySelectorAll('.star-btn');
        let selected = parseInt(ratingInput.value) || 0;

        function paint(upTo) {
            stars.forEach((btn, idx) => {
                btn.classList.toggle('text-amber-400', idx < upTo);
                btn.classList.toggle('text-gray-300',  idx >= upTo);
            });
        }

        paint(selected);

        stars.forEach(btn => {
            btn.addEventListener('mouseenter', () => paint(parseInt(btn.dataset.star)));
            btn.addEventListener('mouseleave', () => paint(selected));
            btn.addEventListener('click', () => {
                selected           = parseInt(btn.dataset.star);
                ratingInput.value  = selected;
                paint(selected);
            });
        });
    }

    /* ---------- anime.js entrance animations ---------- */
    if (typeof anime === 'undefined') return;

    anime({
        targets: '#product-show-grid [data-product-panel]',
        translateY: [20, 0],
        opacity:    [0, 1],
        delay:      anime.stagger(120, { start: 90 }),
        duration:   720,
        easing:     'easeOutCubic'
    });

    anime({
        targets: '#related-products-grid [data-card]',
        translateY: [18, 0],
        opacity:    [0, 1],
        delay:      anime.stagger(80, { start: 140 }),
        duration:   640,
        easing:     'easeOutCubic'
    });

    anime({
        targets: '#reviews-section .bg-white',
        translateY: [12, 0],
        opacity:    [0, 1],
        delay:      anime.stagger(60, { start: 200 }),
        duration:   500,
        easing:     'easeOutCubic'
    });
});
</script>
@endpush
@endsection
