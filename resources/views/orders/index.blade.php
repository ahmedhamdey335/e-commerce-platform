@extends('layouts.app')

@section('title', 'My Orders - ' . config('app.name'))

@section('content')
<div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">My Orders</h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Track and review your order history.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Order</p>
                            <p class="font-bold text-gray-900 dark:text-white">#{{ $order->id }}</p>
                        </div>
                        <div class="hidden sm:block w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Placed on</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="hidden sm:block w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                            <p class="font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @elseif($order->status === 'shipped') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                            @elseif($order->status === 'cancelled') bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400
                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <a href="{{ route('orders.show', ['id' => $order->id]) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                            View details →
                        </a>
                    </div>
                </div>

                <!-- Order Items Preview -->
                <div class="px-6 py-4">
                    <div class="flex items-center gap-3 flex-wrap">
                        @foreach($order->items->take(4) as $item)
                            <div class="flex items-center gap-2">
                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex-shrink-0">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900 dark:text-white truncate max-w-[120px]">{{ $item->product->name ?? 'Product' }}</p>
                                    <p class="text-gray-500 dark:text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        @endforeach
                        @if($order->items->count() > 4)
                            <span class="text-sm text-gray-500 dark:text-gray-400">+{{ $order->items->count() - 4 }} more</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <svg class="mx-auto h-20 w-20 text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No orders yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">You haven't placed any orders yet. Start shopping to see your orders here.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
