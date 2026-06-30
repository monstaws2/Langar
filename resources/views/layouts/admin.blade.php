<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Langar Motor') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-[#1A1A1A] text-white flex flex-col min-h-screen">
                <div class="p-4 text-2xl font-semibold text-center border-b border-gray-700">
                    Admin Panel
                </div>
                <nav class="flex-1 py-4">
                    <ul>
                        <li>
                            <x-admin-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                Dashboard
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                                Products
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                Categories
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.brands.index')" :active="request()->routeIs('admin.brands.*')">
                                Brands
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.motorcycle-models.index')" :active="request()->routeIs('admin.motorcycle-models.*')">
                                Motorcycle Models
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                Orders
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                                Customers
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.inventory.index')" :active="request()->routeIs('admin.inventory.*')">
                                Inventory
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.analytics.index')" :active="request()->routeIs('admin.analytics.*')">
                                Analytics
                            </x-admin-nav-link>
                        </li>
                        <li>
                            <x-admin-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                Settings
                            </x-admin-nav-link>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Page Content -->
            <div class="flex-1 flex flex-col">
                <header class="flex items-center justify-between p-4 bg-white shadow dark:bg-gray-800">
                    <div class="flex items-center">
                        <!-- Hamburger -->
                        <button class="text-gray-500 hover:text-gray-700 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out md:hidden">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-600 focus:outline-none">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</body>
</html>
