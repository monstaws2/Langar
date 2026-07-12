<!DOCTYPE html>
<html lang="fa" dir="rtl" class="bg-brand-offwhite">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1A1A1A">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'پنل مدیریت') | خانه‌ی موتور</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .font-num { font-family: 'Inter', 'Vazirmatn', sans-serif; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased bg-brand-offwhite text-brand-charcoal" x-data="{ sidebarOpen: false }">
<div class="min-h-screen flex">

    {{-- Mobile sidebar backdrop --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-30 lg:hidden"></div>

    {{-- Sidebar (RTL: on the right) --}}
    <aside class="fixed top-0 right-0 z-40 h-screen w-64 bg-brand-charcoal text-gray-300 flex flex-col transition-transform duration-300 lg:translate-x-0 lg:static lg:h-auto"
           :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'">
        <div class="flex items-center justify-between px-6 h-16 border-b border-white/10 shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-brand-red flex items-center justify-center shrink-0">
                    <i data-lucide="anchor" class="w-5 h-5 text-white"></i>
                </div>
                <div class="leading-tight">
                    <div class="text-white font-bold text-base">خانه‌ی<span class="text-brand-red"> موتور</span></div>
                    <div class="text-[11px] text-gray-400">پنل مدیریت</div>
                </div>
            </a>
            {{-- Close button for mobile --}}
            <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded hover:bg-white/10">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 no-scrollbar">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                <span>داشبورد</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="package" class="w-5 h-5 shrink-0"></i>
                <span>محصولات</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="shopping-cart" class="w-5 h-5 shrink-0"></i>
                <span>سفارش‌ها</span>
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
                <span>مشتریان</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="folder-tree" class="w-5 h-5 shrink-0"></i>
                <span>دسته‌بندی‌ها</span>
            </a>
            <a href="{{ route('admin.brands.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="tags" class="w-5 h-5 shrink-0"></i>
                <span>برندها</span>
            </a>
            <a href="{{ route('admin.motorcycle-models.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.motorcycle-models.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="bike" class="w-5 h-5 shrink-0"></i>
                <span>مدل‌های موتور</span>
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.inventory.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="package-check" class="w-5 h-5 shrink-0"></i>
                <span>انبار</span>
            </a>
            <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.analytics.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="bar-chart-3" class="w-5 h-5 shrink-0"></i>
                <span>گزارش‌ها</span>
            </a>
            @php $__pendingReviews = \App\Models\Review::where('is_approved', false)->count(); @endphp
            <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="message-square" class="w-5 h-5 shrink-0"></i>
                <span>نظرات</span>
                @if($__pendingReviews > 0)
                    <span class="mr-auto bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">{{ $__pendingReviews }}</span>
                @endif
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-brand-red text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                <i data-lucide="settings" class="w-5 h-5 shrink-0"></i>
                <span>تنظیمات</span>
            </a>
        </nav>

        <div class="p-3 border-t border-white/10 shrink-0">
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:bg-brand-red hover:text-white transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5 shrink-0"></i>
                    <span>خروج از حساب</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main column --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top header --}}
        <header class="sticky top-0 z-20 bg-white border-b border-gray-200 h-16 flex items-center px-4 sm:px-6 gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="menu" class="w-5 h-5 text-gray-600"></i>
            </button>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-brand-charcoal flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="leading-tight hidden sm:block">
                    <div class="text-sm font-semibold text-brand-charcoal">{{ auth()->user()->name }}</div>
                    <div class="text-[11px] text-gray-500">{{ auth()->user()->is_admin ? 'مدیر کل' : 'کاربر' }}</div>
                </div>
            </div>

            <div class="flex-1 max-w-md mx-auto hidden sm:block">
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" placeholder="جستجو در محصولات، سفارش‌ها، مشتریان..." class="w-full bg-gray-100 rounded-lg pr-9 pl-4 py-2 text-sm border-0 focus:ring-2 focus:ring-brand-red/30 focus:bg-white transition-all">
                </div>
            </div>

            <a href="{{ route('home') }}" target="_blank" class="p-2 rounded-lg hover:bg-gray-100 transition-colors hidden sm:flex items-center gap-1 text-sm text-gray-600" title="مشاهده سایت">
                <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>

            <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="bell" class="w-5 h-5 text-gray-600"></i>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-brand-red rounded-full"></span>
            </button>
        </header>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="px-4 sm:px-6 pt-4">
                <div class="flex items-center gap-2 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                    <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="px-4 sm:px-6 pt-4">
                <div class="flex items-center gap-2 rounded-lg border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</div>

<script>
    window.renderIcons = function () {
        if (window.lucide) { window.lucide.createIcons(); }
    };
    document.addEventListener('DOMContentLoaded', window.renderIcons);
</script>
@stack('scripts')
</body>
</html>
