@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - ' . config('app.name'))

@section('content')
<div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ url('/orders') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">My Orders</a></li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </li>
                <li class="text-gray-900 dark:text-gray-200 font-medium">Order #{{ $order->id }}</li>
            </ol>
        </nav>
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Order #{{ $order->id }}</h1>
            <span class="px-4 py-1.5 rounded-full text-sm font-semibold
                @if($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                @elseif($order->status === 'shipped') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                @elseif($order->status === 'cancelled') bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400
                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                @endif">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Placed on {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
        <!-- Order Items -->
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Items Ordered</h2>
                </div>
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                    <li class="flex py-6 px-6">
                        <div class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1 flex flex-col justify-between">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-base font-medium text-gray-900 dark:text-white">
                                        @if($item->product)
                                            <a href="{{ url('/products/'.$item->product->id) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">Product no longer available</span>
                                        @endif
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-base font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($item->price, 2) }} each</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Shipping Address</h2>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300">{{ $order->address }}</p>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="mt-8 lg:mt-0 lg:col-span-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-24">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">Order Summary</h2>
                @php
                    $itemsTotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                    $shipping = 5.00;
                    $tax = $itemsTotal * 0.1;
                @endphp
                <dl class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex justify-between">
                        <dt>Subtotal</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($itemsTotal, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Shipping</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($shipping, 2) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Taxes</dt>
                        <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($tax, 2) }}</dd>
                    </div>
                    <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                        <dd class="text-xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($order->total_price, 2) }}</dd>
                    </div>
                </dl>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Payment Method</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Cash on Delivery
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ url('/orders') }}" class="w-full flex items-center justify-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        ← Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
