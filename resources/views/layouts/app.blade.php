<!DOCTYPE html>
<html lang="fa" dir="rtl" class="bg-brand-offwhite">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Per-page meta description via @section('meta_description') --}}
    <meta name="keywords" content="قطعات موتورسیکلت، قطعات یدکی موتور، لنگرود، گیلان، هوندا، یاماها، سوزوکی، کاوازاکی، خانه موتور">
    <meta name="theme-color" content="#1A1A1A">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Store",
        "name": "خانه‌ی موتور",
        "alternateName": "khanemotor",
        "description": "فروشگاه تخصصی قطعات یدکی موتورسیکلت در لنگرود گیلان",
        "telephone": "+989936492894",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "راه پشته، جنب افق کوروش",
            "addressLocality": "لنگرود",
            "addressRegion": "گیلان",
            "addressCountry": "IR"
        },
        "openingHours": "Mo-Su 09:00-21:00",
        "url": "{{ url('/') }}"
    }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <meta name="description" content="@yield('meta_description', 'خانه‌ی موتور - فروشگاه تخصصی قطعات یدکی موتورسیکلت در لنگرود گیلان. قطعات اصل با ضمانت اصالت. ارسال به سراسر ایران.')">
    <title>@yield('title', 'صفحه اصلی') | خانه‌ی موتور</title>

    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .font-num { font-family: 'Inter', 'Vazirmatn', sans-serif; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased bg-brand-offwhite text-brand-charcoal min-h-screen flex flex-col">

    @include('layouts.navigation')

    <main class="flex-1">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Flash messages -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="flex items-center gap-2 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="flex items-center gap-2 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="flex items-center gap-2 rounded-lg border border-amber-300 bg-amber-50 px-4 py-3 text-amber-800">
                        <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                        <div class="flex items-center gap-2 mb-2">
                            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                            <span class="font-medium">لطفاً خطاهای زیر را برطرف کنید:</span>
                        </div>
                        <ul class="mr-6 list-disc text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    @include('layouts.footer')

    <script>
        window.renderIcons = function () {
            if (window.lucide) { window.lucide.createIcons(); }
        };
        document.addEventListener('DOMContentLoaded', window.renderIcons);
    </script>
    @stack('scripts')
</body>
</html>
