@extends('layouts.admin')

@section('title', 'جزئیات نظر')

@section('content')
<div class="space-y-6 max-w-3xl">

    {{-- Back --}}
    <a href="{{ route('admin.reviews.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-red transition-colors">
        <i data-lucide="arrow-right" class="w-4 h-4"></i>
        بازگشت به لیست نظرات
    </a>

    {{-- Review card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">

        {{-- Header row --}}
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <h1 class="text-lg font-bold text-brand-charcoal">
                    نظر درباره:
                    <a href="{{ route('products.show', $review->product->slug) }}" target="_blank"
                       class="text-brand-red hover:underline">{{ $review->product->name }}</a>
                </h1>
                <div class="mt-1.5 flex items-center gap-2 flex-wrap">
                    <span class="text-sm text-gray-500">
                        از: <strong class="text-brand-charcoal">{{ $review->user->name }}</strong>
                    </span>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs text-gray-400 font-num">
                        {{ \App\Support\Format::digits($review->created_at->translatedFormat('Y/m/d H:i')) }}
                    </span>
                    @if($review->is_verified_purchase)
                        <span class="inline-flex items-center gap-1 text-xs text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded-full">
                            <i data-lucide="shield-check" class="w-3 h-3"></i>
                            خرید تأیید شده
                        </span>
                    @endif
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="flex items-center gap-2 flex-wrap">
                @if(!$review->is_approved)
                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            تأیید نظر
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm font-medium transition-colors">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                            رد کردن
                        </button>
                    </form>
                @endif
                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                      onsubmit="return confirm('آیا از حذف این نظر اطمینان دارید؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-brand-red hover:text-white text-brand-red rounded-lg text-sm font-medium transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        حذف
                    </button>
                </form>
            </div>
        </div>

        {{-- Stars --}}
        <div class="flex items-center gap-2">
            @include('partials.star-rating', ['rating' => $review->rating, 'size' => 'w-5 h-5'])
            <span class="text-sm text-gray-500">{{ $review->rating }} از ۵</span>
        </div>

        {{-- Title + body --}}
        @if($review->title)
            <h2 class="font-bold text-brand-charcoal">{{ $review->title }}</h2>
        @endif
        <div class="bg-gray-50 rounded-xl p-4 text-gray-700 leading-relaxed whitespace-pre-line text-sm">{{ $review->body }}</div>

        {{-- Status --}}
        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-xs text-gray-500">وضعیت فعلی:</span>
            @if($review->is_approved)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                    <i data-lucide="check" class="w-3 h-3"></i>تأیید شده
                </span>
                @if($review->approved_at)
                    <span class="text-xs text-gray-400 font-num">
                        در {{ \App\Support\Format::digits($review->approved_at->translatedFormat('Y/m/d')) }}
                    </span>
                @endif
            @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                    <i data-lucide="clock" class="w-3 h-3"></i>در انتظار تأیید
                </span>
            @endif
        </div>
    </div>

    {{-- Admin reply --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-brand-charcoal mb-4 flex items-center gap-2">
            <i data-lucide="message-square" class="w-5 h-5 text-brand-red"></i>
            پاسخ مدیر فروشگاه
        </h3>

        @if($review->admin_reply)
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-900 leading-relaxed mb-4 whitespace-pre-line">
                {{ $review->admin_reply }}
            </div>
        @endif

        <form action="{{ route('admin.reviews.reply', $review) }}" method="POST" class="space-y-3">
            @csrf
            <textarea name="admin_reply" rows="4"
                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all resize-none"
                placeholder="{{ $review->admin_reply ? 'ویرایش پاسخ...' : 'پاسخ خود را بنویسید...' }}">{{ old('admin_reply', $review->admin_reply) }}</textarea>
            @error('admin_reply')
                <p class="text-xs text-brand-red">{{ $message }}</p>
            @enderror
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-red hover:bg-red-700 text-white rounded-xl text-sm font-bold transition-colors">
                <i data-lucide="send" class="w-4 h-4"></i>
                {{ $review->admin_reply ? 'ویرایش پاسخ' : 'ارسال پاسخ' }}
            </button>
        </form>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () { window.renderIcons(); });
</script>
@endpush
@endsection
