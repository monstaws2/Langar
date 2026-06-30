<!DOCTYPE html>
<html lang="fa" dir="rtl" class="bg-brand-offwhite">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#1A1A1A">

        <title>{{ $header ?? config('app.name', 'لنگر موتور') }} | پنل مدیریت</title>

        <!-- Fonts: Vazirmatn for Persian text, Inter for numbers -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>

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
            <!-- Sidebar -->
            <aside class="w-64 bg-[#C0392B] text-white flex flex-col min-h-screen">
                <div class="p-4 text-2xl font-semibold text-center border-b border-white/20">
                    لنگر موتور
                </div>
                <nav class="flex-1 py-4">
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                                داشبورد
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                                محصولات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="tags" class="w-5 h-5 mr-3"></i>
                                دسته‌بندی‌ها
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.brands.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.brands.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="brand" class="w-5 h-5 mr-3"></i>
                                برندها
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.motorcycle-models.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.motorcycle-models.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="truck" class="w-5 h-5 mr-3"></i>
                                modèles موتورسیکلت
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
                                سفارشات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.customers.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                                مشتریان
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.inventory.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.inventory.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="package-check" class="w-5 h-5 mr-3"></i>
                                انبار
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.analytics.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.analytics.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="bar-chart-2" class="w-5 h-5 mr-3"></i>
                                آمار
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'bg-white/10' : 'hover:bg-white/10' }} transition-colors">
                                <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                                تنظیمات
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Page Content -->
            <div class="flex-1 flex flex-col">
                <header class="flex items-center justify-between p-4 bg-white shadow dark:bg-gray-100">
                    <div class="flex items-center">
                        <!-- Hamburger -->
                        <button class="text-gray-500 hover:text-gray-700 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out md:hidden" id="mobile-menu-button">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $header ?? 'داشبورد' }}
                        </h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600 focus:outline-none">
                                خروج
                            </button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Mobile Sidebar -->
        <div class="fixed inset-0 z-50 hidden md:invisible" id="mobile-sidebar">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeMobileSidebar"></div>
            <div class="relative w-64 bg-[#C0392B] text-white flex flex-col h-full">
                <div class="p-4 text-2xl font-semibold text-center border-b border-white/20">
                    لنگر موتور
                </div>
                <nav class="flex-1 py-4">
                    <ul>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                                داشبورد
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="package" class="w-5 h-5 mr-3"></i>
                                محصولات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="tags" class="w-5 h-5 mr-3"></i>
                                دسته‌بندی‌ها
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.brands.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.brands.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="brand" class="w-5 h-5 mr-3"></i>
                                برندها
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.motorcycle-models.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.motorcycle-models.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="truck" class="w-5 h-5 mr-3"></i>
                                modèles موتورسیکلت
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
                                سفارشات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.customers.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                                مشتریان
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.inventory.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.inventory.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="package-check" class="w-5 h-5 mr-3"></i>
                                انبار
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.analytics.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.analytics.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="bar-chart-2" class="w-5 h-5 mr-3"></i>
                                آمار
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'bg-white/20' : 'hover:bg-white/20' }} transition-colors">
                                <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                                تنظیمات
                            </a>
                        </li>
                    </ul>
                </nav>
                <button class="mt-auto p-4 text-white border-t border-white/20" @click="closeMobileSidebar">
                    بستن منو
                </button>
            </div>
        </div>

        <!-- Render Lucide icons -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });

            // Mobile sidebar toggle
            document.addEventListener('DOMContentLoaded', function () {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileSidebar = document.getElementById('mobile-sidebar');

                if (mobileMenuButton && mobileSidebar) {
                    mobileMenuButton.addEventListener('click', function () {
                        mobileSidebar.classList.toggle('hidden');
                        mobileSidebar.classList.toggle('md:invisible');
                    });

                    // Close sidebar when clicking outside
                    mobileSidebar.addEventListener('click', function (e) {
                        if (e.target === mobileSidebar) {
                            mobileSidebar.classList.add('hidden');
                            mobileSidebar.classList.add('md:invisible');
                        }
                    });
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>