@extends('components.admin-layout')

@section('header')
    مشتریان
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
                <i data-lucide="users" class="w-5 h-5 text-brand-red"></i>
                <h2 class="text-xl font-bold text-brand-charcoal">مشتریان</h2>
            </div>
            <div class="flex gap-4">
                <form action="{{ route('admin.customers.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" placeholder="جستجو مشتری..." value="{{ request()->input('search') }}" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-brand-red focus:border-brand-red">
                    <button type="submit" class="px-4 py-2 bg-brand-red text-white font-medium rounded-md hover:bg-brand-red-dark transition-colors">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">نام</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ایمیل</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">تاریخ ثبت نام</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">تعداد سفارشات</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">عمليات</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-brand-charcoal">{{ $customer->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $customer->created_at->format('Y/m/d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium font-num">{{ $customer->orders_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">
                                هیچ مشتری یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    </div>
@stop