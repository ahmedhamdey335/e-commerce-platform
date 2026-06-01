@extends('layouts.app')

@section('title', 'Products - ' . config('app.name'))

@section('content')
<div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Our Products</h1>
        <p class="mt-2 text-gray-500 dark:text-gray-400">Find what you're looking for.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar / Filters -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 sticky top-24">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products.index') }}" class="block px-2 py-1.5 text-sm rounded-lg {{ !request('category') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 font-medium' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors' }}">
                            All Categories
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block px-2 py-1.5 text-sm rounded-lg {{ request('category') === $category->slug ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 font-medium' : 'text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors' }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <h3 class="font-bold text-gray-900 dark:text-white mb-4 mt-8">Search</h3>
                <form action="{{ route('products.index') }}" method="GET">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-9 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm focus:ring-indigo-500 focus:border-indigo-500 dark:text-white outline-none transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="flex-1">
            @if($products->count() > 0)
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($products as $product)
                    <div class="group relative bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl dark:shadow-none dark:border dark:border-gray-700 transition-all duration-300 overflow-hidden flex flex-col">
                        <div class="aspect-w-4 aspect-h-3 bg-gray-200 dark:bg-gray-700 relative overflow-hidden h-56 flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                            @else
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity flex items-center justify-center">
                                <a href="{{ route('products.show', ['id' => $product->id]) }}" class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 text-sm font-medium px-4 py-2 rounded-lg shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-all">View Details</a>
                            </div>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-base font-bold text-gray-900 dark:text-white truncate pr-2">
                                    <a href="{{ route('products.show', ['id' => $product->id]) }}">
                                        <span aria-hidden="true" class="absolute inset-0 z-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-base font-extrabold text-indigo-600 dark:text-indigo-400">${{ number_format($product->price, 2) }}</p>
                            </div>
                            <div class="mb-3 text-xs text-gray-500 dark:text-gray-400">
                                @foreach($product->categories as $cat)
                                    <span class="inline-block bg-gray-100 dark:bg-gray-700 rounded px-1.5 py-0.5 mr-1">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">{{ $product->description }}</p>
                            <div class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between z-10 relative">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($product->stock > 0)
                                        <span class="text-green-500 font-medium">In Stock</span> ({{ $product->stock }})
                                    @else
                                        <span class="text-rose-500 font-medium">Out of Stock</span>
                                    @endif
                                </span>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="p-1.5 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500 dark:hover:text-white transition-colors" title="Add to Cart" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-24 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter to find what you're looking for.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
