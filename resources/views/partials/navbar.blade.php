<nav class="bg-white/85 dark:bg-gray-950/85 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/20">
                        E
                    </div>
                    <div class="space-y-0.5 text-left">
                        <span class="block text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-500">Commerce</span>
                        <span class="block text-xs text-gray-500 dark:text-gray-400">Marketplace</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center space-x-4 ml-8">
                    <a href="{{ route('products.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Shop</a>

                    @if(isset($layoutCategories) && $layoutCategories->isNotEmpty())
                        <div class="relative group">
                            <button type="button" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">
                                Categories
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-72 rounded-3xl bg-white dark:bg-gray-900 shadow-2xl border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-20">
                                <div class="py-3">
                                    @foreach($layoutCategories->take(8) as $category)
                                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">{{ $category->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <form action="{{ route('products.index') }}" method="GET" class="hidden lg:flex items-center bg-gray-100 dark:bg-gray-900 rounded-full px-3 py-1.5 border border-gray-200 dark:border-gray-700">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="bg-transparent border-none outline-none text-sm text-gray-900 dark:text-gray-100 placeholder:text-gray-500 dark:placeholder:text-gray-400 px-3 py-2 w-64" />
                    <button type="submit" class="text-indigo-600 dark:text-indigo-400 p-2 rounded-full hover:bg-indigo-50 dark:hover:bg-indigo-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="relative p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    @if(!empty($cartCount) && $cartCount > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white bg-rose-500 rounded-full">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-300 transition-colors">
                            {{ auth()->user()->name }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="absolute right-0 w-48 mt-2 py-2 bg-white dark:bg-gray-900 rounded-3xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-200 dark:border-gray-700">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Admin dashboard</a>
                            @elseif(auth()->user()->role === 'seller')
                                <a href="{{ route('seller.dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Seller dashboard</a>
                            @endif
                            <a href="{{ route('orders.index') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">My orders</a>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-600 text-white text-sm font-medium shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition-all">Sign up</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
