<footer class="w-full bg-brand-charcoal text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- About -->
        <div class="md:col-span-2">
            <div class="text-2xl font-extrabold text-brand-red">لنگر موتور</div>
            <p class="text-gray-400 mt-3 leading-relaxed max-w-md">
                فروشگاه تخصصی قطعات یدکی موتورسیکلت هوندا، یاماها، سوزوکی و کاوازاکی. تامین قطعات اصل با ضمانت اصالت کالا و ارسال سریع به سراسر ایران.
            </p>
            <div class="mt-5 flex items-center gap-3">
                <a href="#" aria-label="اینستاگرام" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-red transition flex items-center justify-center">
                    <i data-lucide="instagram" class="w-5 h-5"></i>
                </a>
                <a href="#" aria-label="تلگرام" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-red transition flex items-center justify-center">
                    <i data-lucide="send" class="w-5 h-5"></i>
                </a>
                <a href="#" aria-label="واتساپ" class="w-9 h-9 rounded-full bg-white/10 hover:bg-brand-red transition flex items-center justify-center">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                </a>
            </div>
        </div>

        <!-- Quick links -->
        <div>
            <h4 class="font-bold mb-4">دسترسی سریع</h4>
            <ul class="space-y-2">
                <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition">خانه</a></li>
                <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white text-sm transition">محصولات</a></li>
                <li><a href="{{ route('brands.index') }}" class="text-gray-400 hover:text-white text-sm transition">برندها</a></li>
                <li><a href="{{ route('contact.index') }}" class="text-gray-400 hover:text-white text-sm transition">تماس با ما</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div>
            <h4 class="font-bold mb-4">تماس با ما</h4>
            <ul class="space-y-3 text-gray-400 text-sm">
                <li class="flex items-center gap-2">
                    <i data-lucide="map-pin" class="w-4 h-4 shrink-0 text-brand-orange"></i>
                    <span>تهران، خیابان آزادی</span>
                </li>
                <li class="flex items-center gap-2">
                    <i data-lucide="phone" class="w-4 h-4 shrink-0 text-brand-orange"></i>
                    <a href="tel:+982112345678" class="font-num hover:text-white transition" dir="ltr">۰۲۱-۱۲۳۴۵۶۷۸</a>
                </li>
                <li class="flex items-center gap-2">
                    <i data-lucide="mail" class="w-4 h-4 shrink-0 text-brand-orange"></i>
                    <a href="mailto:info@langarmotor.ir" class="hover:text-white transition">info@langarmotor.ir</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 py-4 text-center text-gray-500 text-sm">
        تمامی حقوق برای لنگر موتور محفوظ است &copy; ۱۴۰۳
    </div>
</footer>
