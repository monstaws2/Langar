@php
    $cartCount = array_sum(session('cart', []));
@endphp

<!-- Top bar -->
<div class="w-full bg-brand-charcoal-light text-gray-300 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <i data-lucide="truck" class="w-4 h-4 text-brand-orange"></i>
            <span>ارسال رایگان برای خریدهای بالای ۵۰۰٬۰۰۰ تومان</span>
        </div>
        <a href="tel:+982112345678" class="flex items-center gap-2 hover:text-white transition" dir="ltr">
            <span class="font-num">۰۲۱-۱۲۳۴۵۶۷۸</span>
            <i data-lucide="phone" class="w-4 h-4 text-brand-orange"></i>
        </a>
    </div>
</div>

<!-- Main Navbar -->
<nav id="site-navbar" x-data="{ open: false }" class="sticky top-0 z-50 w-full bg-brand-charcoal shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 h-[72px]">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                <span class="w-10 h-10 rounded-lg bg-brand-red flex items-center justify-center">
                    <i data-lucide="bike" class="w-6 h-6 text-white"></i>
                </span>
                <span class="leading-tight">
                    <span class="block text-xl font-extrabold text-brand-red">لنگر موتور</span>
                    <span class="block text-[11px] text-gray-400">قطعات اصل موتورسیکلت</span>
                </span>
            </a>

            <!-- Search bar -->
            <form action="{{ route('search.index') }}" method="GET" class="hidden md:flex flex-1 max-w-xl">
                <div class="relative w-full">
                    <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجوی قطعات..."
                        class="w-full bg-white/95 rounded-lg border-0 py-2.5 pr-10 pl-4 text-sm text-brand-charcoal placeholder-gray-400 focus:ring-2 focus:ring-brand-orange">
                </div>
            </form>

            <!-- Actions -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative inline-flex items-center justify-center w-10 h-10 rounded-lg text-white hover:bg-white/10 transition" aria-label="سبد خرید">
                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                    <span class="absolute -top-1 -left-1 min-w-[18px] h-[18px] px-1 inline-flex items-center justify-center text-[10px] font-bold leading-none text-white bg-brand-orange rounded-full font-num">{{ \App\Support\Format::digits($cartCount) }}</span>
                </a>

                <!-- Auth -->
                @auth
                    <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 border border-brand-red text-white hover:bg-brand-red rounded-lg px-3 py-2 text-sm transition">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span>حساب کاربری</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 border border-brand-red text-white hover:bg-brand-red rounded-lg px-3 py-2 text-sm transition">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>ورود | ثبت‌نام</span>
                    </a>
                @endauth

                <!-- Mobile Hamburger -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-white hover:bg-white/10" aria-label="منو">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- Desktop nav links -->
        <div class="hidden md:flex items-center gap-1 h-11 border-t border-white/10">
            <a href="{{ route('home') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('home') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">خانه</a>
            <a href="{{ route('products.index') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('products.*') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">محصولات</a>
            <a href="{{ route('brands.index') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('brands.*') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">برندها</a>
            <a href="{{ route('search.index') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('search.*') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">جستجوی پیشرفته</a>
            <a href="{{ route('contact.index') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('contact.*') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">تماس با ما</a>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="open" x-cloak class="md:hidden bg-brand-charcoal border-t border-white/10">
        <div class="px-4 py-3 space-y-3">
            <form action="{{ route('search.index') }}" method="GET" class="relative">
                <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="جستجوی قطعات..."
                    class="w-full bg-white/95 rounded-lg border-0 py-2.5 pr-10 pl-4 text-sm text-brand-charcoal placeholder-gray-400 focus:ring-2 focus:ring-brand-orange">
            </form>
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">خانه</a>
                <a href="{{ route('products.index') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">محصولات</a>
                <a href="{{ route('brands.index') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">برندها</a>
                <a href="{{ route('contact.index') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">تماس با ما</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">حساب کاربری</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">ورود | ثبت‌نام</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
