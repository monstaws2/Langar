@extends('layouts.admin')

@section('title', 'نظرات محصولات')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-brand-charcoal">نظرات محصولات</h1>
            <p class="text-sm text-gray-500 mt-1">مدیریت، تأیید و پاسخ به نظرات مشتریان</p>
        </div>
        @if($pendingCount > 0)
            <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 px-4 py-2.5 rounded-xl text-sm font-medium">
                <i data-lucide="clock" class="w-4 h-4"></i>
                {{ \App\Support\Format::digits($pendingCount) }} نظر در انتظار تأیید
            </div>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.reviews.index') }}"
          class="bg-white rounded-xl border border-gray-100 p-4 flex flex-wrap gap-3 items-end">
        <div class="flex flex-col gap-1">
            <label class="text-xs text-gray-500">محصول</label>
            <select name="product_id"
                    class="bg-gray-50 rounded-lg px-3 py-2 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all min-w-[160px]">
                <option value="">همه محصولات</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-xs text-gray-500">وضعیت</label>
            <select name="status"
                    class="bg-gray-50 rounded-lg px-3 py-2 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all">
                <option value="">همه</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>در انتظار تأیید</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>تأیید شده</option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-xs text-gray-500">امتیاز</label>
            <select name="rating"
                    class="bg-gray-50 rounded-lg px-3 py-2 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all">
                <option value="">همه امتیازها</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} ستاره</option>
                @endfor
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-xs text-gray-500">نوع خرید</label>
            <select name="verified"
                    class="bg-gray-50 rounded-lg px-3 py-2 text-sm border border-gray-200 focus:ring-2 focus:ring-brand-red/30 focus:border-brand-red/50 transition-all">
                <option value="">همه</option>
                <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>خرید تأیید شده</option>
                <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>بدون خرید</option>
            </select>
        </div>
        <button type="submit"
                class="px-4 py-2 bg-brand-red hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
            اعمال فیلتر
        </button>
        @if(request()->hasAny(['product_id', 'status', 'rating', 'verified']))
            <a href="{{ route('admin.reviews.index') }}"
               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors">
                حذف فیلتر
            </a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-right">
                        <th class="px-5 py-3 font-medium">کاربر</th>
                        <th class="px-5 py-3 font-medium">محصول</th>
                        <th class="px-5 py-3 font-medium">امتیاز</th>
                        <th class="px-5 py-3 font-medium">نظر</th>
                        <th class="px-5 py-3 font-medium">وضعیت</th>
                        <th class="px-5 py-3 font-medium">تاریخ</th>
                        <th class="px-5 py-3 font-medium text-center">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        {{-- User --}}
                        <td class="px-5 py-4">
                            <div class="font-medium text-brand-charcoal text-sm">{{ $review->user->name }}</div>
                            <div class="text-xs text-gray-400 truncate max-w-[130px]">{{ $review->user->email ?? $review->user->phone }}</div>
                            @if($review->is_verified_purchase)
                                <span class="mt-1 inline-flex items-center gap-1 text-[10px] text-green-700 bg-green-50 px-1.5 py-0.5 rounded-full">
                                    <i data-lucide="shield-check" class="w-3 h-3"></i>خرید تأیید شده
                                </span>
                            @endif
                        </td>
                        {{-- Product --}}
                        <td class="px-5 py-4">
                            <a href="{{ route('products.show', $review->product->slug) }}" target="_blank"
                               class="text-brand-red hover:underline text-sm line-clamp-2 max-w-[160px] block">
                                {{ $review->product->name }}
                            </a>
                        </td>
                        {{-- Stars --}}
                        <td class="px-5 py-4">
                            @include('partials.star-rating', ['rating' => $review->rating, 'size' => 'w-4 h-4'])
                        </td>
                        {{-- Body --}}
                        <td class="px-5 py-4 max-w-xs">
                            @if($review->title)
                                <div class="font-medium text-brand-charcoal text-sm mb-0.5">{{ $review->title }}</div>
                            @endif
                            <div class="text-gray-500 text-xs line-clamp-2">{{ $review->body }}</div>
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-4">
                            @if($review->is_approved)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <i data-lucide="check" class="w-3 h-3"></i>تأیید شده
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <i data-lucide="clock" class="w-3 h-3"></i>در انتظار
                                </span>
                            @endif
                            @if($review->admin_reply)
                                <div class="mt-1">
                                    <span class="inline-flex items-center gap-1 text-[10px] text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded-full">
                                        <i data-lucide="message-square" class="w-3 h-3"></i>پاسخ داده شده
                                    </span>
                                </div>
                            @endif
                        </td>
                        {{-- Date --}}
                        <td class="px-5 py-4 text-gray-500 font-num text-xs whitespace-nowrap">
                            {{ \App\Support\Format::digits($review->created_at->translatedFormat('Y/m/d')) }}
                        </td>
                        {{-- Actions --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('admin.reviews.show', $review) }}"
                                   class="p-2 rounded-lg text-gray-500 hover:bg-brand-red/10 hover:text-brand-red transition-colors"
                                   title="مشاهده / پاسخ">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                @if(!$review->is_approved)
                                    <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="p-2 rounded-lg text-gray-500 hover:bg-green-50 hover:text-green-600 transition-colors"
                                                title="تأیید">
                                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="p-2 rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600 transition-colors"
                                                title="رد کردن">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="inline"
                                      onsubmit="return confirm('آیا از حذف این نظر اطمینان دارید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg text-gray-500 hover:bg-red-50 hover:text-brand-red transition-colors"
                                            title="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i data-lucide="message-square" class="w-7 h-7"></i>
                                </div>
                                <div class="text-sm">هیچ نظری یافت نشد.</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="text-sm text-gray-500 font-num">
                نمایش {{ $reviews->firstItem() }} تا {{ $reviews->lastItem() }} از {{ $reviews->total() }} نظر
            </span>
            {{ $reviews->links() }}
        </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.anime) {
            anime({
                targets: '.space-y-6 > *',
                opacity:    [0, 1],
                translateY: [12, 0],
                duration:   400,
                delay:      anime.stagger(60),
                easing:     'easeOutCubic',
            });
        }
        window.renderIcons();
    });
</script>
@endpush
@endsection
