<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Seller Dashboard - {{ config('app.name', 'E-Commerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col fixed h-full z-10 transition-transform">
        <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center text-white font-bold">
                    S
                </div>
                <span class="text-lg font-bold tracking-tight">SellerHub</span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('seller.dashboard') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-teal-600 bg-teal-50 dark:bg-teal-500/10 dark:text-teal-400">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            
            <a href="{{ route('seller.products.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-teal-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                My Products
            </a>

            <a href="{{ route('seller.orders.index') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-teal-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Order Fulfillment
            </a>
        </div>
        
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-teal-100 dark:bg-teal-900/50 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold">
                    {{ substr(auth()->user()->name ?? 'S', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ auth()->user()->name ?? 'Seller User' }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ auth()->user()->email ?? 'seller@example.com' }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-rose-500 transition-colors" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 flex flex-col min-h-screen">
        <!-- Top header for mobile and general actions -->
        <header class="h-16 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 sticky top-0 z-10">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                @yield('header', 'Seller Dashboard')
            </h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300 font-medium">View Storefront</a>
            </div>
        </header>

        <div class="p-6 flex-1">
            @yield('content')
        </div>
    </main>

</body>
</html>
