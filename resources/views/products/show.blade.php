@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')
<div class="bg-white dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Home</a></li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </li>
                <li><a href="{{ route('products.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Products</a></li>
                <li>
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                </li>
                <li class="text-gray-900 dark:text-gray-200 font-medium" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <!-- Product Image -->
            <div class="lg:max-w-lg lg:self-start">
                <div class="aspect-w-1 aspect-h-1 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-md">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover">
                    @else
                        <div class="w-full h-96 flex items-center justify-center text-gray-400">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="mt-10 px-4 sm:px-0 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h1>
                
                <div class="mt-3 flex items-center justify-between">
                    <p class="text-3xl text-indigo-600 dark:text-indigo-400 font-bold">${{ number_format($product->price, 2) }}</p>
                    
                    <div class="flex items-center space-x-2">
                        @if($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                In Stock ({{ $product->stock }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                <span class="w-2 h-2 mr-2 bg-rose-500 rounded-full"></span>
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6 text-gray-700 dark:text-gray-300">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Categories</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="inline-flex items-center px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Description</h3>
                    <div class="prose prose-sm text-gray-600 dark:text-gray-400">
                        {{ nl2br(e($product->description)) }}
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Sold by</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold">
                            {{ substr($product->seller->name ?? 'S', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $product->seller->name ?? 'Unknown Seller' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Verified Seller</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex">
                    <form action="{{ route('cart.store') }}" method="POST" class="w-full flex gap-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="w-24">
                            <label for="quantity" class="sr-only">Quantity</label>
                            <select id="quantity" name="quantity" class="w-full h-12 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none px-4 appearance-none" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                @for($i = 1; $i <= min(10, max(1, $product->stock)); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" class="flex-1 bg-indigo-600 border border-transparent rounded-xl py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-indigo-500/30 disabled:bg-gray-400 disabled:shadow-none disabled:transform-none disabled:cursor-not-allowed" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            Add to bag
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($relatedProducts->count() > 0)
<!-- Related Products Section -->
<div class="bg-gray-50 dark:bg-gray-800/50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8">You may also like</h2>
        
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($relatedProducts as $related)
            <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md dark:shadow-none dark:border dark:border-gray-700 transition-all overflow-hidden flex flex-col">
                <div class="aspect-w-4 aspect-h-3 bg-gray-200 dark:bg-gray-700 relative overflow-hidden h-48 flex items-center justify-center">
                    @if($related->image)
                        <img src="{{ asset('storage/'.$related->image) }}" alt="{{ $related->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500">
                    @else
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    @endif
                    <a href="{{ route('products.show', ['id' => $related->id]) }}" class="absolute inset-0 z-10"><span class="sr-only">View {{ $related->name }}</span></a>
                </div>
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $related->name }}</h3>
                    <p class="mt-1 text-sm font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($related->price, 2) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
