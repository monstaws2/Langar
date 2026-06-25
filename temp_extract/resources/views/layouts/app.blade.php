<!DOCTYPE html>
<html lang="fa" dir="rtl" class="bg-brand-offwhite">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#1A1A1A">
        <meta name="description" content="لنگر موتور؛ فروشگاه تخصصی قطعات یدکی موتورسیکلت هوندا، یاماها، سوزوکی و کاوازاکی با ضمانت اصالت کالا و ارسال سریع به سراسر ایران.">

        <title>{{ config('app.name', 'لنگر موتور') }} | قطعات یدکی موتورسیکلت</title>

        <!-- Fonts: Vazirmatn for Persian text, Inter for numbers -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Icons & micro-animations -->
        <script src="https://unpkg.com/lucide@latest"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

        <style>
            body { font-family: 'Vazirmatn', sans-serif; }
            .font-num { font-family: 'Inter', 'Vazirmatn', sans-serif; }
            [x-cloak] { display: none !important; }
            /* Hide scrollbar for horizontal category strip */
            .no-scrollbar::-webkit-scrollbar { display: none; }
            .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
    </head>
    <body class="antialiased bg-brand-offwhite text-brand-charcoal">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash message -->
            @if (session('success'))
                <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
                    <div class="flex items-center gap-2 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>

            @include('layouts.footer')
        </div>

        <!-- Render Lucide icons -->
        <script>
            window.renderIcons = function () {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            };
            document.addEventListener('DOMContentLoaded', window.renderIcons);
        </script>

        @stack('scripts')
    </body>
</html>
