@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">سبد خرید</h1>
        <p class="text-gray-600 mt-2">محصولات انتخابی خود را مرور کنید</p>
    </div>

    <!-- Cart Empty State -->
    <div class="bg-white rounded-lg shadow-md p-12 text-center" id="cart-empty-state">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <h2 class="text-2xl font-semibold text-gray-900 mt-4">سبد خرید شما خالی است</h2>
        <p class="text-gray-600 mt-2">برای شروع خرید، به صفحه محصولات بروید</p>
        <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
            بازگشت به محصولات
        </a>
    </div>

    <!-- Cart Items (Will be shown when items exist) -->
    @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8" id="cart-content">
        <!-- Items List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-right text-gray-700 font-semibold">محصول</th>
                            <th class="px-6 py-3 text-right text-gray-700 font-semibold">قیمت</th>
                            <th class="px-6 py-3 text-right text-gray-700 font-semibold">تعداد</th>
                            <th class="px-6 py-3 text-right text-gray-700 font-semibold">جمع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-gray-900">{{ number_format($item->price) }} تومان</td>
                            <td class="px-6 py-4 text-gray-900">1</td>
                            <td class="px-6 py-4 text-gray-900 font-semibold">{{ number_format($item->price) }} تومان</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 h-fit">
            <h2 class="text-xl font-bold text-gray-900 mb-6">خلاصه سفارش</h2>
            <div class="space-y-4">
                <div class="flex justify-between text-gray-700">
                    <span>جمع کل:</span>
                    <span>{{ number_format($total) }} تومان</span>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <button class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        تکمیل سفارش
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof anime === 'undefined') {
                return;
            }

            if (document.getElementById('cart-empty-state')) {
                anime({
                    targets: '#cart-empty-state',
                    translateY: [20, 0],
                    opacity: [0, 1],
                    duration: 700,
                    easing: 'easeOutCubic'
                });
            }

            if (document.getElementById('cart-content')) {
                anime({
                    targets: '#cart-content > *',
                    translateY: [18, 0],
                    opacity: [0, 1],
                    delay: anime.stagger(120, { start: 120 }),
                    duration: 700,
                    easing: 'easeOutCubic'
                });
            }
        });
    </script>
@endpush
@endsection
