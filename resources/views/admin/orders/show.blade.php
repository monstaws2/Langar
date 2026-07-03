@extends('layouts.admin')

@section('title', 'جزئیات سفارش #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <i data-lucide="truck" class="w-5 h-5 text-brand-red"></i>
            <h2 class="text-xl font-bold text-brand-charcoal">جزئیات سفارش</h2>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-brand-red hover:text-brand-red-dark">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
            بازگشت به لیست
        </a>
    </div>

    <div class="bg-white rounded-xl shadow">
        <div class="p-6">
            <!-- Order Header -->
            <div class="mb-6 pb-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">شماره سفارش:</p>
                        <h3 class="text-2xl font-bold text-brand-charcoal">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    </div>
                    <div class="text-sm space-y-1">
                        <span class="text-gray-500">تاریخ:</span>
                        <span class="font-medium">{{ $order->created_at->format('Y/m/d') }} {{ $order->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-4">اطلاعات مشتری</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">نام:</p>
                        <p class="text-lg font-medium">{{ $order->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">ایمیل:</p>
                        <p class="text-lg font-medium break-all">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">شماره تماس:</p>
                        <p class="text-lg font-medium">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">آدرس:</p>
                        <p class="text-lg font-medium break-all">{{ $order->address }}, {{ $order->city }}, کد پستی: {{ $order->postal_code }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-4">کالاهای سفارش شده</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                            <!-- Product Image -->
                            <div class="w-16 h-16 flex-shrink-0 rounded-xl bg-white border border-gray-200 flex items-center justify-center">
                                @php
                                    $product = $item->product;
                                    $image = $product ? $product->image : null;
                                    $icon = $product && $product->category ? $product->category->icon : 'package';
                                @endphp
                                @if($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="" class="w-full h-full object-contain rounded">
                                @else
                                    <i data-lucide="{{ $icon }}" class="w-8 h-8 text-brand-charcoal/30"></i>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-brand-charcoal">{{ $item->product_name }}</div>
                                @if($item->product && $item->product->brand)
                                    <div class="text-sm text-gray-600">{{ $item->product->brand->name }}</div>
                                @endif
                            </div>

                            <!-- Quantity & Price -->
                            <div class="text-center space-x-3">
                                <div class="text-sm text-gray-600">{{ $item->quantity }} عدد</div>
                                <div class="font-bold text-brand-charcoal">{{ \App\Support\Format::price($item->price) }} تومان</div>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-center w-24 font-bold text-brand-charcoal">
                                {{ \App\Support\Format::price($item->price * $item->quantity) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-4">جمع کل سفارش</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>جمع محصولات:</span>
                        <span class="font-num font-bold text-brand-charcoal">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>هزینه ارسال:</span>
                        <span class="text-green-600 font-semibold">رایگان</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3">
                        <div class="flex justify-between text-gray-600 font-bold">
                            <span>مبلغ قابل پرداخت:</span>
                            <span class="font-num font-bold text-brand-red text-xl">{{ \App\Support\Format::price($order->total_price) }} تومان</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-brand-charcoal mb-4">وضعیت سفارش</h3>
                <div class="space-y-3">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" id="statusForm">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center gap-4">
                            <select name="status" id="statusSelect" class="w-48 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>در انتظار</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>ارسال شده</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تحویل شده</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-brand-red hover:bg-brand-red-dark text-white rounded-lg font-medium transition">
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.renderIcons) window.renderIcons();
            if (typeof anime === 'undefined') return;
        });
    </script>
@endpush