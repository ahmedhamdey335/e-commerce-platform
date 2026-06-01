@extends('layouts.app')

@section('title', 'Welcome to ' . config('app.name'))

@section('content')
<!-- Hero Section -->
<div class="relative bg-white dark:bg-gray-900 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Premium products</span>
                        <span class="block text-indigo-600 dark:text-indigo-400">delivered to you</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Discover amazing items from top sellers around the world. Secure checkout, fast shipping, and exceptional customer service.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ url('/products') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition-all transform hover:-translate-y-1 shadow-lg shadow-indigo-500/30">
                                Shop Now
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ url('/products') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/30 hover:bg-indigo-200 dark:hover:bg-indigo-900/50 md:py-4 md:text-lg md:px-10 transition-colors">
                                View Categories
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <div class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full bg-gradient-to-br from-indigo-100 to-purple-200 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
             <div class="w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl absolute"></div>
             <div class="w-64 h-64 rounded-full bg-purple-500/10 blur-3xl absolute -translate-x-32 translate-y-32"></div>
             <svg class="w-48 h-48 text-indigo-500/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
    </div>
</div>

<!-- Featured Products Section -->
<div class="bg-gray-50 dark:bg-gray-900 pt-12 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Latest Arrivals</h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 sm:mt-4">
                Check out the newest additions to our collection.
            </p>
        </div>

        <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($featuredProducts as $product)
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl dark:shadow-none dark:border dark:border-gray-700 transition-all duration-300 overflow-hidden flex flex-col">
                <div class="aspect-w-4 aspect-h-3 bg-gray-200 dark:bg-gray-700 relative overflow-hidden h-64 flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                    @else
                        <svg class="w-20 h-20 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity flex items-center justify-center">
                        <a href="{{ url('/products/'.$product->id) }}" class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 font-medium px-4 py-2 rounded-lg shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-all">View Details</a>
                    </div>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate pr-4">
                            <a href="{{ url('/products/'.$product->id) }}">
                                <span aria-hidden="true" class="absolute inset-0 z-0"></span>
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>
                    <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between z-10 relative">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            @if($product->stock > 0)
                                <span class="text-green-500 font-medium">In Stock</span> ({{ $product->stock }})
                            @else
                                <span class="text-rose-500 font-medium">Out of Stock</span>
                            @endif
                        </span>
                        <form action="{{ url('/cart/add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="p-2 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500 dark:hover:text-white transition-colors" title="Add to Cart" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-12 text-center">
            <a href="{{ url('/products') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition-colors">
                View all products
            </a>
        </div>
    </div>
</div>
@endsection
