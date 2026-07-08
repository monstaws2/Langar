@php
    $cartCount = array_sum(session('cart', []));
@endphp

<!-- Top bar -->
<div class="w-full bg-brand-charcoal-light text-gray-300 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <i data-lucide="truck" class="w-4 h-4 text-brand-orange"></i>
                <span>ارسال رایگان برای خریدهای بالای ۵۰۰٬۰۰۰ تومان</span>
            </div>
            <span class="hidden sm:inline text-gray-600">|</span>
            <a href="{{ route('faq') }}" class="hidden sm:flex items-center gap-1 hover:text-white transition">
                <i data-lucide="help-circle" class="w-3 h-3"></i>
                <span>راهنما</span>
            </a>
        </div>
        <a href="tel:+982112345678" class="flex items-center gap-2 hover:text-white transition" dir="ltr">
            <span class="font-num">۰۲۱-۱۲۳۴۵۶۷۸</span>
            <i data-lucide="phone" class="w-4 h-4 text-brand-orange"></i>
        </a>
    </div>
</div>

<!-- Main Navbar -->
<nav id="site-navbar" x-data="{ open: false, userMenu: false }" class="sticky top-0 z-50 w-full bg-brand-charcoal shadow-lg">
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
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -left-1 min-w-[18px] h-[18px] px-1 inline-flex items-center justify-center text-[10px] font-bold leading-none text-white bg-brand-orange rounded-full font-num">{{ \App\Support\Format::digits($cartCount) }}</span>
                    @endif
                </a>

                <!-- Auth -->
                @auth
                    <div class="relative" @click.away="userMenu = false">
                        <button @click="userMenu = !userMenu" class="hidden sm:inline-flex items-center gap-1.5 border border-brand-red text-white hover:bg-brand-red rounded-lg px-3 py-2 text-sm transition">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span class="max-w-[80px] truncate">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-3 h-3" x-bind:class="userMenu ? 'rotate-180' : ''"></i>
                        </button>

                        <!-- User Dropdown -->
                        <div x-show="userMenu" x-cloak x-transition class="absolute left-0 top-full mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="font-medium text-brand-charcoal text-sm truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                                <i data-lucide="layout-dashboard" class="w-4 h-4 text-gray-400"></i>
                                <span>داشبورد</span>
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                                <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400"></i>
                                <span>سفارش‌های من</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition">
                                <i data-lucide="user-cog" class="w-4 h-4 text-gray-400"></i>
                                <span>ویرایش پروفایل</span>
                            </a>
                            @if(auth()->user()->is_admin)
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-brand-red hover:bg-red-50 transition">
                                    <i data-lucide="shield" class="w-4 h-4"></i>
                                    <span>پنل مدیریت</span>
                                </a>
                            @endif
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-right">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    <span>خروج از حساب</span>
                                </button>
                            </form>
                        </div>
                    </div>
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
            <a href="{{ route('search.index') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('search.*') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">جستجو</a>
            <a href="{{ route('contact.index') }}" class="text-sm px-4 py-2 rounded-md transition {{ request()->routeIs('contact.*') ? 'text-white bg-white/10' : 'text-gray-300 hover:text-white' }}">تماس با ما</a>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="open" x-cloak x-transition class="md:hidden bg-brand-charcoal border-t border-white/10">
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
                <a href="{{ route('search.index') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">جستجو</a>
                <a href="{{ route('contact.index') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">تماس با ما</a>
                <a href="{{ route('faq') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">سوالات متداول</a>
                @auth
                    <div class="border-t border-white/10 my-2 pt-2">
                        <a href="{{ route('dashboard') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">حساب کاربری</a>
                        <a href="{{ route('orders.index') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">سفارش‌های من</a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-200 block px-3 py-2 rounded-md hover:bg-white/10 text-sm">ورود | ثبت‌نام</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
