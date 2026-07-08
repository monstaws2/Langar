@extends('layouts.admin')

@section('title', 'تنظیمات')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">تنظیمات</h1>
            <p class="text-sm text-gray-500 mt-1">مدیریت تنظیمات فروشگاه لنگر موتور</p>
        </div>
    </div>

    {{-- Settings Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Store Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i data-lucide="store" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal">اطلاعات فروشگاه</h3>
                    <p class="text-xs text-gray-500">نام و مشخصات کلی</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نام فروشگاه</label>
                    <input type="text" value="{{ $settings['store_name'] }}" readonly class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 text-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">واحد پول</label>
                    <input type="text" value="{{ $settings['currency'] }}" readonly class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 text-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">تعداد آیتم در هر صفحه</label>
                    <input type="text" value="{{ $settings['items_per_page'] }}" readonly class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 text-gray-600 font-num">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">آستانه موجودی کم</label>
                    <input type="text" value="{{ $settings['low_stock_threshold'] }}" readonly class="w-full bg-gray-50 rounded-lg px-4 py-2.5 text-sm border border-gray-200 text-gray-600 font-num">
                </div>
            </div>
        </div>

        {{-- Cache & Performance --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <i data-lucide="zap" class="w-5 h-5 text-purple-600"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-brand-charcoal">عملکرد و کش</h3>
                    <p class="text-xs text-gray-500">مدیریت کش برنامه</p>
                </div>
            </div>

            <div class="space-y-3 mb-6">
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <div class="flex items-center gap-3">
                        <i data-lucide="route" class="w-4 h-4 text-gray-500"></i>
                        <span class="text-sm text-gray-600">کش روت‌ها</span>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $cacheStats['routes_cached'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $cacheStats['routes_cached'] ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                        {{ $cacheStats['routes_cached'] ? 'فعال' : 'غیرفعال' }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <div class="flex items-center gap-3">
                        <i data-lucide="settings-2" class="w-4 h-4 text-gray-500"></i>
                        <span class="text-sm text-gray-600">کش کانفیگ</span>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $cacheStats['config_cached'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $cacheStats['config_cached'] ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                        {{ $cacheStats['config_cached'] ? 'فعال' : 'غیرفعال' }}
                    </span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50">
                    <div class="flex items-center gap-3">
                        <i data-lucide="layout" class="w-4 h-4 text-gray-500"></i>
                        <span class="text-sm text-gray-600">کش ویوها</span>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $cacheStats['views_cached'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $cacheStats['views_cached'] ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                        {{ $cacheStats['views_cached'] ? 'فعال' : 'غیرفعال' }}
                    </span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.clear-cache') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-brand-charcoal text-white rounded-lg text-sm font-medium hover:bg-brand-charcoal-light transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    <span>پاک کردن کش برنامه</span>
                </button>
            </form>
        </div>
    </div>

    {{-- System Info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                <i data-lucide="server" class="w-5 h-5 text-gray-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-brand-charcoal">اطلاعات سیستم</h3>
                <p class="text-xs text-gray-500">نسخه‌ها و مشخصات فنی</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-gray-50">
                <p class="text-xs text-gray-500 mb-1">نسخه Laravel</p>
                <p class="text-sm font-semibold text-brand-charcoal font-num">{{ app()->version() }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50">
                <p class="text-xs text-gray-500 mb-1">نسخه PHP</p>
                <p class="text-sm font-semibold text-brand-charcoal font-num">{{ phpversion() }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50">
                <p class="text-xs text-gray-500 mb-1">محیط</p>
                <p class="text-sm font-semibold text-brand-charcoal">{{ config('app.env') }}</p>
            </div>
            <div class="p-4 rounded-xl bg-gray-50">
                <p class="text-xs text-gray-500 mb-1">اشکال‌زدایی</p>
                <p class="text-sm font-semibold text-brand-charcoal">{{ config('app.debug') ? 'فعال' : 'غیرفعال' }}</p>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.anime) {
            anime({
                targets: '.space-y-6 > *',
                opacity: [0, 1],
                translateY: [12, 0],
                duration: 400,
                delay: anime.stagger(60),
                easing: 'easeOutCubic',
            });
        }
        window.renderIcons();
    });
</script>
@endpush
@endsection
