@php
    $totalQuantity = array_reduce($cartItems, fn($c, $i) => $c + $i->quantity, 0);
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 text-right">
        <h1 class="text-3xl font-extrabold text-brand-charcoal">سبد خرید</h1>
        <p class="text-gray-500 mt-2">محصولات انتخابی خود را مرور کنید</p>
    </div>

    @if(count($cartItems) === 0)
        <!-- Empty state -->
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center" id="cart-empty-state">
            <div class="w-20 h-20 rounded-full bg-brand-offwhite flex items-center justify-center mx-auto">
                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-300"></i>
            </div>
            <h2 class="text-2xl font-bold text-brand-charcoal mt-5">سبد خرید شما خالی است</h2>
            <p class="text-gray-500 mt-2">برای شروع خرید، به صفحه محصولات بروید.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-bold transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                بازگشت به محصولات
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-content" x-data="{
            updateQuantity(itemId, newQty, originalQty, price) {
                // Send AJAX request to update cart
                const url = "{{ url('cart/update/0') }}".replace('0', itemId);
                const formData = new FormData();
                formData.append('_token', Laravel.csrfToken);
                formData.append('quantity', newQty);

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network error');
                    }
                    return response.text(); // we expect a redirect, but we ignore body
                })
                .then(() => {
                    // Optimistic update: update UI
                    this.updateItemUI(itemId, newQty, price);
                })
                .catch(error => {
                    // Revert change on error
                    alert('خطا در به‌روزرسانی سبد خرید. لطفاً دوباره امتحان کنید.');
                    this.updateItemUI(itemId, originalQty, price);
                });
            },
            updateItemUI(itemId, newQty, price) {
                const itemEl = document.querySelector(`[data-item-id='${itemId}']`);
                if (!itemEl) return;

                // Update quantity display
                const qtyDisplay = itemEl.querySelector('.item-quantity');
                if (qtyDisplay) {
                    qtyDisplay.textContent = newQty;
                }

                // Update subtotal
                const subtotal = newQty * price;
                const subtotalEl = itemEl.querySelector('.item-subtotal');
                if (subtotalEl) {
                    subtotalEl.textContent = new Intl.NumberFormat('fa-IR').format(subtotal);
                }

                // Update total cart price
                this.updateCartTotal();
            },
            updateCartTotal() {
                let total = 0;
                document.querySelectorAll('.item-subtotal').forEach(el => {
                    const val = parseFloat(el.textContent.replace(/[^\d.-]/g, '')) || 0;
                    total += val;
                });
                const totalEl = document.querySelector('#cart-total-amount');
                if (totalEl) {
                    totalEl.textContent = new Intl.NumberFormat('fa-IR').format(Math.round(total));
                }
            }
        }">
            <!-- Items column -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div
                        :key="'item-{{ $item->id }}'"
                        data-item-id="{{ $item->id }}"
                        class="bg-white rounded-2xl shadow-sm p-4 sm:p-5"
                        x-data="{
                            quantity: {{ $item->quantity }},
                            price: {{ $item->price }},
                            id: {{ $item->id }}
                        }"
                        x-init="console.log('Item init:', this.id)"
                    >
                        <div class="flex items-center gap-4">
                            <!-- Product image / icon -->
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-brand-offwhite flex items-center justify-center shrink-0">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <i data-lucide="{{ $item->category_icon }}" class="w-8 h-8 sm:w-10 sm:h-10 text-brand-charcoal/30"></i>
                                @endif
                            </div>

                            <!-- Product info -->
                            <div class="flex-1 min-w-0 text-right">
                                <a href="{{ route('products.show', $item->slug) }}" class="font-bold text-brand-charcoal hover:text-brand-red transition line-clamp-2">
                                    {{ $item->name }}
                                </a>
                                <div class="mt-2 font-num text-brand-red font-bold">
                                    {{ \App\Support\Format::price($item->price) }}
                                    <span class="text-xs font-normal text-gray-500">تومان</span>
                                </div>

                                <!-- Mobile remove -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-2 sm:hidden">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 text-xs text-brand-red hover:text-brand-red-dark transition">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        حذف
                                    </button>
                                </form>
                            </div>

                            <!-- Desktop: quantity, subtotal, remove -->
                            <div class="hidden sm:flex items-center gap-5">
                                <!-- Quantity stepper -->
                                <div class="text-center flex items-center gap-2">
                                    <button
                                        type="button"
                                        @click="if (quantity > 1) { quantity--; updateQuantity(id, quantity, quantity + 1, price); }"
                                        :disabled="quantity <= 1"
                                        class="p-1 rounded-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 text-brand-red hover:text-brand-red-dark"
                                    >
                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                    </button>
                                    <span class="item-quantity w-8 text-center font-num">{{ $item->quantity }}</span>
                                    <button
                                        type="button"
                                        @click="quantity++; updateQuantity(id, quantity, quantity - 1, price);"
                                        class="p-1 rounded-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 text-brand-red hover:text-brand-red-dark"
                                    >
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-center min-w-[90px] item-subtotal">
                                    <span class="font-bold text-brand-charcoal font-num">{{ \App\Support\Format::price($item->line_total) }}</span>
                                    <span class="text-xs text-gray-400">تومان</span>
                                </div>

                                <!-- Desktop remove -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-brand-red hover:bg-red-50 transition"
                                        aria-label="حذف">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Mobile: quantity + subtotal -->
                        <div class="sm:hidden flex items-center justify-between gap-3 mt-3 pt-3 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    @click="if (quantity > 1) { quantity--; updateQuantity(id, quantity, quantity + 1, price); }"
                                    :disabled="quantity <= 1"
                                    class="p-1 rounded-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 text-brand-red hover:text-brand-red-dark"
                                >
                                    <i data-lucide="minus" class="w-3 h-3"></i>
                                </button>
                                <span class="item-quantity w-6 text-center font-num">{{ $item->quantity }}</span>
                                <button
                                    type="button"
                                    @click="quantity++; updateQuantity(id, quantity, quantity - 1, price);"
                                    class="p-1 rounded-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 text-brand-red hover:text-brand-red-dark"
                                >
                                    <i data-lucide="plus" class="w-3 h-3"></i>
                                </button>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-400">جمع</div>
                                <div class="font-bold text-brand-charcoal font-num item-subtotal-mobile">{{ \App\Support\Format::price($item->line_total) }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Clear cart -->
                <div class="text-right">
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" onclick="return confirm('آیا از پاک کردن سبد خرید اطمینان دارید؟')"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm text-brand-red hover:bg-red-50 rounded-lg transition">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                            پاک کردن سبد خرید
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary sidebar -->
            <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
                <h2 class="text-xl font-bold text-brand-charcoal mb-6">خلاصه سفارش</h2>
                <div class="space-y-4">
                    <div class="flex justify-between text-gray-600">
                        <span>تعداد کالا:</span>
                        <span class="font-num font-bold text-brand-charcoal" id="cart-total-quantity">{{ \App\Support\Format::digits($totalQuantity) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>جمع کل:</span>
                        <span class="font-num font-bold text-brand-charcoal" id="cart-total-amount">{{ \App\Support\Format::price($total) }} <span class="text-xs font-normal text-gray-400">تومان</span></span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال:</span>
                        <span class="text-green-600 font-semibold">رایگان</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 space-y-3">
                        <a href="{{ route('checkout.index') }}" class="w-full inline-flex items-center justify-center gap-2 bg-brand-red hover:bg-brand-red-dark text-white py-3 rounded-lg font-bold transition">
                            <i data-lucide="credit-card" class="w-5 h-5"></i>
                            تکمیل سفارش
                        </a>
                        <a href="{{ route('products.index') }}"
                            class="block text-center w-full inline-flex items-center justify-center gap-2 border border-gray-200 text-brand-charcoal hover:bg-brand-offwhite py-3 rounded-lg font-bold transition">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            ادامه خرید
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;

            var el = document.getElementById('cart-empty-state') || document.getElementById('cart-content');
            if (el) {
                anime({
                    targets: el,
                    translateY: [20, 0],
                    opacity: [0, 1],
                    duration: 650,
                    easing: 'easeOutCubic'
                });
            }
        });
    </script>
@endpush
@endsection