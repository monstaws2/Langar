@extends('components.admin-layout')

@section('header')
    داشبورد
@stop

@section('content')
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="box" class="w-6 h-6 text-brand-red"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">محصولات</p>
                    <p class="text-2xl font-bold text-brand-charcoal">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-brand-red"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">سفارشات</p>
                    <p class="text-2xl font-bold text-brand-charcoal">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="users" class="w-6 h-6 text-brand-red"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">مشتریان</p>
                    <p class="text-2xl font-bold text-brand-charcoal">{{ $totalCustomers }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-brand-red"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">درآمد</p>
                    <p class="text-2xl font-bold text-brand-charcoal">{{ number_format($totalRevenue) }} تومان</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders and Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-bold text-brand-charcoal">آخرین سفارشات</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-brand-red hover:text-brand-red-dark">
                    مشاهده همه <i data-lucide="chevron-left" class="ml-2 h-4 w-4"></i>
                </a>
            </div>
            <div class="p-6">
                @if($recentOrders->isEmpty())
                    <div class="text-center py-12 text-gray-500">
                        <i data-lucide="shopping-cart" class="w-12 h-12 mx-auto mb-4 text-gray-300"></i>
                        <p>هیچ سفارشی ثبت نشده است.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                        <p class="text-sm text-gray-500">شماره: #{{ $order->id }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($order->status == 'paid') bg-green-100 text-green-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'shipped') bg-indigo-100 text-indigo-800
                                            @elseif($order->status == 'delivered') bg-indigo-100 text-indigo-800
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800
                                            endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <span class="text-sm font-num text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="mt-2 text-right text-sm font-num">
                                    {{ number_format($order->total_amount) }} تومان
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-brand-charcoal">دسترسی سریع</h2>
            </div>
            <div class="p-6 space-y-4">
                <a href="{{ route('admin.products.create') }}" class="flex items-center justify-between px-4 py-3 bg-brand-red/50 rounded-lg hover:bg-brand-red/100 transition-colors">
                    <div class="flex items-center">
                        <i data-lucide="plus" class="w-5 h-5 mr-3 text-brand-red"></i>
                        <span class="text-lg font-medium text-brand-charcoal">افزودن محصول</span>
                    </div>
                    <i data-lucide="chevron-left" class="w-4 h-4 text-gray-400 hover:text-brand-red transition-colors"></i>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="flex items-center justify-between px-4 py-3 bg-brand-red/50 rounded-lg hover:bg-brand-red/100 transition-colors">
                    <div class="flex items-center">
                        <i data-lucide="tag" class="w-5 h-5 mr-3 text-brand-red"></i>
                        <span class="text-lg font-medium text-brand-charcoal">افزودن دسته‌بندی</span>
                    </div>
                    <i data-lucide="chevron-left" class="w-4 h-4 text-gray-400 hover:text-brand-red transition-colors"></i>
                </a>
                <a href="{{ route('admin.brands.create') }}" class="flex items-center justify-between px-4 py-3 bg-brand-red/50 rounded-lg hover:bg-brand-red/100 transition-colors">
                    <div class="flex items-center">
                        <i data-lucide="brand" class="w-5 h-5 mr-3 text-brand-red"></i>
                        <span class="text-lg font-medium text-brand-charcoal">افزودن برند</span>
                    </div>
                    <i data-lucide="chevron-left" class="w-4 h-4 text-gray-400 hover:text-brand-red transition-colors"></i>
                </a>
            </div>
        </div>
    </div>
@stop