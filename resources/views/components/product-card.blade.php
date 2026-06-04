@props(['product'])

<div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-xl dark:shadow-none dark:border dark:border-gray-700 transition-all duration-300 overflow-hidden flex flex-col">
    <div class="aspect-w-4 aspect-h-3 bg-gray-200 dark:bg-gray-700 relative overflow-hidden h-56 flex items-center justify-center">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" />
        @else
            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        @endif
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity flex items-center justify-center">
            <a href="{{ route('products.show', ['id' => $product->id]) }}" class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 text-sm font-medium px-4 py-2 rounded-2xl shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-all">View details</a>
        </div>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <div class="flex justify-between items-start gap-3 mb-3">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">{{ $product->name }}</h3>
            <span class="text-base font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($product->price, 2) }}</span>
        </div>

        <div class="mb-3 text-xs text-gray-500 dark:text-gray-400">
            @foreach($product->categories as $cat)
                <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-700 px-2 py-1 mr-1">{{ $cat->name }}</span>
            @endforeach
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-5">{{ $product->description }}</p>

        <div class="mt-auto pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                @if($product->stock > 0)
                    <span class="text-emerald-600 font-medium">In stock</span> ({{ $product->stock }})
                @else
                    <span class="text-rose-500 font-medium">Out of stock</span>
                @endif
            </span>

            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="p-2 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500 dark:hover:text-white transition-colors" title="Add to cart" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>
