@extends('components.admin-layout')

@section('header')
    سفارشات
@stop

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 p-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-800">
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
                <i data-lucide="truck" class="w-5 h-5 text-brand-red"></i>
                <h2 class="text-xl font-bold text-brand-charcoal">سفارشات</h2>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-brand-red hover:text-brand-red-dark">
                بازآرایی <i data-lucide="rotate-ccw" class="ml-2 h-4 w-4"></i>
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">مشتری</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">مبلغ</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">وضعیت</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">عملیات</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brand-charcoal">
                                {{ $order->user->name }}
                                <br>
                                <span class="text-xs text-gray-500">{{ $order->user->email }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('Y/m/d') }}
                                <br>
                                <span class="text-xs">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium font-num text-right">
                                {{ number_format($order->total_amount) }} تومان
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex items-center gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">
                                هیچ سفارشی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <div class="flex items-center">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
            </div>
            <div class="flex items-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@stop