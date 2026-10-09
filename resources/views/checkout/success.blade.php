@extends('layouts.app')

@section('title', 'Order Success - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-140px)] py-12 flex items-center justify-center">
    <div class="max-w-md w-full px-4 sm:px-6 lg:px-8 text-center">
        <div class="bg-white dark:bg-gray-800 shadow-xl shadow-indigo-100/20 dark:shadow-none border border-gray-100 dark:border-gray-700 rounded-3xl p-8 sm:p-12 relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 dark:bg-green-900/30 mb-8 relative">
                <div class="absolute inset-0 rounded-full border-4 border-green-500/20 animate-ping"></div>
                <svg class="h-12 w-12 text-green-600 dark:text-green-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Order Confirmed!</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8">
                Thank you for your purchase. Your order <span class="font-bold text-gray-900 dark:text-gray-200">#{{ session('order_id') }}</span> has been placed successfully and is being processed.
            </p>

            <div class="space-y-4">
                <a href="{{ route('orders.index') }}" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-indigo-500/30">
                    View Order Details
                </a>
                <a href="{{ route('products.index') }}" class="w-full flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 shadow-sm text-base font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
