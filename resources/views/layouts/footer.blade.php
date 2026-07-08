<footer class="w-full bg-brand-charcoal text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- About -->
        <div class="lg:col-span-1">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-9 h-9 rounded-lg bg-brand-red flex items-center justify-center">
                    <i data-lucide="bike" class="w-5 h-5 text-white"></i>
                </span>
                <span class="text-xl font-extrabold text-brand-red">خانه‌ی موتور</span>
            </div>
            <p class="text-gray-400 leading-relaxed text-sm">
                فروشگاه تخصصی قطعات یدکی موتورسیکلت هوندا، یاماها، سوزوکی و کاوازاکی. تامین قطعات اصل با ضمانت اصالت کالا و ارسال سریع به سراسر ایران.
            </p>
            <div class="mt-5 flex items-center gap-3">
                <span class="text-xs text-gray-500 block">ما را دنبال کنید:</span>
                <a href="https://instagram.com/khanemotor" target="_blank" rel="noopener" aria-label="اینستاگرام" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-red transition flex items-center justify-center">
                    <i data-lucide="instagram" class="w-5 h-5"></i>
                </a>
                <a href="https://t.me/khanemotor" target="_blank" rel="noopener" aria-label="تلگرام" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-red transition flex items-center justify-center">
                    <i data-lucide="send" class="w-5 h-5"></i>
                </a>
                <a href="https://wa.me/989936492894" target="_blank" rel="noopener" aria-label="واتساپ" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-red transition flex items-center justify-center">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                </a>
            </div>
        </div>

        <!-- Quick links -->
        <div>
            <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-300">دسترسی سریع</h4>
            <ul class="space-y-3">
                <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> خانه</a></li>
                <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> محصولات</a></li>
                <li><a href="{{ route('brands.index') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> برندها</a></li>
                <li><a href="{{ route('search.index') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> جستجو</a></li>
                <li><a href="{{ route('contact.index') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> تماس با ما</a></li>
            </ul>
        </div>

        <!-- Support & Policies -->
        <div>
            <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-300">پشتیبانی و قوانین</h4>
            <ul class="space-y-3">
                <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> سوالات متداول</a></li>
                <li><a href="{{ route('shipping-returns') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> شرایط ارسال و بازگشت</a></li>
                <li><a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> حریم خصوصی</a></li>
                <li><a href="{{ route('terms-of-service') }}" class="text-gray-400 hover:text-white text-sm transition flex items-center gap-2"><i data-lucide="chevron-left" class="w-3 h-3"></i> شرایط استفاده</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h4 class="font-bold mb-4 text-sm uppercase tracking-wider text-gray-300">تماس با ما</h4>
            <ul class="space-y-4 text-sm">
                <li class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4 text-brand-orange"></i>
                    </div>
                    <span class="text-gray-400">گیلان، لنگرود، راه پشته، جنب افق کوروش</span>
                </li>
                <li class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                        <i data-lucide="phone" class="w-4 h-4 text-brand-orange"></i>
                    </div>
                    <a href="tel:+989936492894" class="text-gray-400 hover:text-white font-num transition" dir="ltr">۰۹۹۳۶۴۹۲۸۹۴</a>
                </li>
                <li class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-4 h-4 text-brand-orange"></i>
                    </div>
                    <a href="mailto:info@khanemotor.ir" class="text-gray-400 hover:text-white transition">info@khanemotor.ir</a>
                </li>
                <li class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                        <i data-lucide="clock" class="w-4 h-4 text-brand-orange"></i>
                    </div>
                    <span class="text-gray-400">هر روز ساعت ۹ صبح تا ۹ شب</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-gray-500 text-sm">تمامی حقوق برای خانه‌ی موتور محفوظ است &copy; ۱۴۰۳</p>
            <div class="flex items-center gap-1 text-gray-500 text-xs">
                <i data-lucide="shield-check" class="w-3 h-3 text-brand-orange"></i>
                <span>خرید امن با ضمانت اصالت کالا</span>
            </div>
        </div>
    </div>
</footer>
