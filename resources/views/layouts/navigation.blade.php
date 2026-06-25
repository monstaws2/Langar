<!-- Announcement Bar -->
<div class="w-full text-center py-2" style="background-color: #C0392B;">
    <p class="text-white text-sm">🏍️ ارسال رایگان برای خریدهای بالای ۵۰۰،۰۰۰ تومان | با ما در واتساپ: ۰۹۱۲-XXX-XXXX</p>
</div>

<!-- Main Navbar -->
<nav id="site-navbar" x-data="{ open: false }" class="sticky top-0 z-50 w-full shadow-lg" style="background-color: #1A1A1A;">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex items-center justify-between h-[70px]">

            <!-- RIGHT: Logo -->
            <div class="flex items-center text-right space-x-3 space-x-reverse">
                <div>
                    <a href="/" class="text-2xl font-extrabold" style="color: #C0392B;">لنگر موتور</a>
                    <div class="text-xs text-gray-400">قطعات اصل موتورسیکلت</div>
                </div>
            </div>

            <!-- CENTER: Links -->
            <div class="hidden md:flex items-center text-center">
                <a href="/" class="text-white text-sm px-4 py-2 hover:text-red-500 {{ request()->is('/') ? 'border-b-2 border-red-500' : '' }}">خانه</a>
                <a href="{{ route('products.index') }}" class="text-white text-sm px-4 py-2 hover:text-red-500 {{ request()->is('products') ? 'border-b-2 border-red-500' : '' }}">محصولات</a>
                <a href="/brands" class="text-white text-sm px-4 py-2 hover:text-red-500 {{ request()->is('brands') ? 'border-b-2 border-red-500' : '' }}">برندها</a>
                <a href="/contact" class="text-white text-sm px-4 py-2 hover:text-red-500 {{ request()->is('contact') ? 'border-b-2 border-red-500' : '' }}">تماس با ما</a>
            </div>

            <!-- LEFT: Actions -->
            <div class="flex items-center space-x-3">
                <!-- Search -->
                <a href="/search" class="text-white hover:text-red-400 hidden sm:inline-flex" aria-label="جستجو">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 0Z" />
                    </svg>
                </a>

                <!-- Cart -->
                <a href="/cart" class="relative inline-flex items-center text-white hover:opacity-90" aria-label="سبد خرید">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <span class="absolute -top-2 -left-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-[#E67E22] rounded-full">۰</span>
                </a>

                <!-- Auth -->
                <a href="/login" class="hidden md:inline-block border border-red-500 text-red-400 hover:bg-red-500 hover:text-white rounded px-3 py-1 text-sm">ورود | ثبت‌نام</a>

                <!-- Mobile Hamburger -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="open" x-cloak class="md:hidden bg-[#1A1A1A] border-t border-gray-800">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="text-white block px-3 py-2 rounded-md hover:bg-gray-800 text-sm">خانه</a>
            <a href="{{ route('products.index') }}" class="text-white block px-3 py-2 rounded-md hover:bg-gray-800 text-sm">محصولات</a>
            <a href="/brands" class="text-white block px-3 py-2 rounded-md hover:bg-gray-800 text-sm">برندها</a>
            <a href="/contact" class="text-white block px-3 py-2 rounded-md hover:bg-gray-800 text-sm">تماس با ما</a>
            <a href="/login" class="text-white block px-3 py-2 rounded-md hover:bg-gray-800 text-sm">ورود</a>
        </div>
    </div>
</nav>
