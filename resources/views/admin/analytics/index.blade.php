@extends('components.admin-layout')

@section('header')
   Analytics
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

        <div class="mb-6">
            <h2 class="text-xl font-bold text-brand-charcoal">آمار و اطلاعات کلی</h2>
            <p class="text-gray-500 mt-1">گزارشات پیشفرض سیستم لنگر موتور</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Products -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="box" class="w-6 h-6 text-brand-red"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">کل محصولات</p>
                        <p class="text-2xl font-bold text-brand-charcoal">{{ $totalProducts ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <!-- Total Orders -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-brand-red"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">کل سفارشات</p>
                        <p class="text-2xl font-bold text-brand-charcoal">{{ $totalOrders ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <!-- Total Customers -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="users" class="w-6 h-6 text-brand-red"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">کل مشتریان</p>
                        <p class="text-2xl font-bold text-brand-charcoal">{{ $totalCustomers ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                    <div class="flex-shrink-0">
                        <i data-lucide="dollar-sign" class="w-6 h-6 text-brand-red"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">درآمد کل</p>
                        <p class="text-2xl font-bold text-brand-charcoal">{{ number_format($totalRevenue ?? 0) }} تومان</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sales Overview -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-brand-charcoal">تحلیل فروش</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="text-center">
                            <i data-lucide="trending-up" class="w-12 h-12 mx-auto mb-4 text-brand-red"></i>
                            <p class="text-lg font-medium text-gray-700">فروش ماهانه</p>
                            <p class="text-2xl font-bold text-brand-charcoal">{{ number_format($monthlySales ?? 0) }} تومان</p>
                        </div>
                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-sm text-gray-500">نسبت به ماه قبل: <span class="font-medium">{{ $monthlyGrowth ?? 0 }}%</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Products -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-brand-charcoal">محصولات محبوب</h2>
                </div>
                <div class="p-4">
                    @if($topProducts->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <i data-lucide="package" class="w-8 h-8 mx-auto mb-3 text-gray-300"></i>
                            <p>هیچ داده‌ای برای نمایش وجود ندارد.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($topProducts as $product)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <i data-lucide="triangle-up" class="w-4 h-4 mr-2 text-brand-red"></i>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $product->name_fa }}</p>
                                            <p class="text-sm text-gray-500">{{ $product->sales_count }} فروش</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                        {{ $product->sales_count }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-brand-charcoal">فعالیت‌های اخیر</h2>
            </div>
            <div class="p-4 space-y-3">
                @if($recentActivities->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <i data-lucide="clock" class="w-8 h-8 mx-auto mb-3 text-gray-300"></i>
                        <p>هیچ فعالیت اخیری ثبت نشده است.</p>
                    </div>
                @else
                    @foreach($recentActivities as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <i data-lucide="{{ $activity->icon ?? 'circle' }}" class="w-5 h-5 {{ $activity->color ?? 'text-gray-400' }} mt-0.5"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $activity->title }}</p>
                                <p class="text-sm text-gray-500">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-400">{{ $activity->time }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop