@extends('components.admin-layout')

@section('header')
    انبار
@stop

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i data-lucide="package-check" class="w-5 h-5 text-brand-red"></i>
                <h2 class="text-xl font-bold text-brand-charcoal">گزارش‌های انبار</h2>
            </div>
            <a href="{{ route('admin.inventory.export') }}" class="inline-flex items-center px-4 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                <i data-lucide="download" class="mr-2 h-4 w-4"></i>
                xuất khẩu گزارش
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Inventory Adjustment -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-brand-charcoal">تنظیمات انبار</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.inventory.adjust') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">محصول</label>
                            <select name="product_id" id="product_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent">
                                <option value="">--- انتخاب محصول ---</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name_fa }} ({{ $product->stock_quantity }} در انبار)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="change_amount" class="block text-sm font-medium text-gray-700 mb-1">مقدار تغییر</label>
                                <input type="number" name="change_amount" id="change_amount" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent" placeholder="مثبت برای افزودن، منفی برای کاهش">
                            </div>
                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">دلیل</label>
                                <select name="reason" id="reason" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent">
                                    <option value="purchase">خرید</option>
                                    <option value="sale">فروش</option>
                                    <option value="adjustment">تنظیمات يدوي</option>
                                    <option value="damage">ضايعات</option>
                                    <option value="loss">Gu mất</option>
                                    <option value="correction">تصحیح</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">یادداشت (اختیاری)</label>
                            <textarea name="note" id="note" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-red focus:border-transparent"></textarea>
                        </div>
                        <div class="flex items-center justify-end">
                            <button type="submit" class="px-6 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                                اعمال تغییر
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inventory Logs -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-brand-charcoal">تاریخچهٔ تغییرات انبار</h2>
                </div>
                <div class="p-4">
                    @if($inventoryLogs->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <i data-lucide="truck" class="w-12 h-12 mx-auto mb-4 text-gray-300"></i>
                            <p>هیچ बदल انباری یافت نشد.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($inventoryLogs->take(10) as $log)
                                <div class="border-b border-gray-200 pb-3 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $log->product->name_fa }}</p>
                                            <p class="text-sm text-gray-500">{{ $log->created_at->format('Y/m/d H:i') }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($log->change_amount > 0) bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            endif">
                                            {{ $log->change_amount > 0 ? '+' : '' }}{{ $log->change_amount }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ ucfirst($log->reason) }}</p>
                                    @if($log->note)
                                        <p class="text-xs text-gray-500 mt-1">{{ $log->note }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-brand-charcoal">هشدار موجودی کم</h2>
                </div>
                <div class="p-4">
                    @if($lowStockProducts->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <i data-lucide="check-circle" class="w-10 h-10 mx-auto mb-3 text-green-400"></i>
                            <p>هیچ محصولی با موجودی کم نیست.</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($lowStockProducts as $product)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i data-lucide="alert-triangle" class="w-4 h-4 mr-2 text-brand-red"></i>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $product->name_fa }}</p>
                                            <p class="text-sm text-gray-500">موجودی: <span class="font-bold text-red-600">{{ $product->stock_quantity }}</span></p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        کم
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop