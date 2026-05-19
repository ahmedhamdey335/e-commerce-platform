@extends('layouts.app')

@section('title', 'Shopping Cart - ' . config('app.name'))

@section('content')
<div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Shopping Cart</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl relative flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 px-4 py-3 rounded-xl relative flex items-center" role="alert">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <div class="lg:col-span-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($cartItems as $item)
                        <li class="flex py-6 px-4 sm:px-6">
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-center object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-between">
                                <div class="relative flex justify-between">
                                    <div>
                                        <h3 class="text-base font-medium text-gray-900 dark:text-white">
                                            <a href="{{ url('/products/'.$item->product->id) }}">{{ $item->product->name }}</a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sold by: {{ $item->product->seller->name ?? 'Unknown' }}</p>
                                    </div>
                                    <p class="text-base font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($item->product->price, 2) }}</p>
                                </div>

                                <div class="mt-4 flex-1 flex items-end justify-between">
                                    <form action="{{ url('/cart/'.$item->id) }}" method="POST" class="flex items-center space-x-3">
                                        @csrf
                                        @method('PUT')
                                        <label for="quantity-{{ $item->id }}" class="sr-only">Quantity</label>
                                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                                            <input type="number" id="quantity-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-16 p-2 text-center text-sm border-none focus:ring-0 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                        </div>
                                        <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Update</button>
                                    </form>

                                    <form action="{{ url('/cart/'.$item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-rose-600 hover:text-rose-500 transition-colors">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Order summary -->
            <div class="mt-16 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">Order summary</h2>

                <div class="flow-root">
                    <dl class="-my-4 text-sm divide-y divide-gray-200 dark:divide-gray-700">
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-gray-600 dark:text-gray-400">Subtotal</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-gray-600 dark:text-gray-400">Shipping estimate</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">$5.00</dd>
                        </div>
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-gray-600 dark:text-gray-400">Tax estimate</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal * 0.1, 2) }}</dd>
                        </div>
                        <div class="py-4 flex items-center justify-between text-base font-bold border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                            <dt class="text-gray-900 dark:text-white">Order total</dt>
                            <dd class="text-indigo-600 dark:text-indigo-400">${{ number_format($subtotal + 5.00 + ($subtotal * 0.1), 2) }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8">
                    <a href="{{ url('/checkout') }}" class="w-full bg-indigo-600 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 py-4 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 flex justify-center items-center">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <svg class="mx-auto h-20 w-20 text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Looks like you haven't added anything to your cart yet. Browse our products and discover great deals.</p>
            <a href="{{ url('/products') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
