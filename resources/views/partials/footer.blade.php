<footer class="bg-white dark:bg-gray-950 border-t border-gray-200 dark:border-gray-800 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:flex sm:items-center sm:justify-between gap-4">
        <div class="space-y-2 text-center sm:text-left">
            <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} {{ config('app.name', 'E-Commerce') }}. Built for seamless marketplace experiences.</p>
            <p class="text-xs text-gray-400">Designed with maintainability, scalability, and usability in mind.</p>
        </div>
        <div class="flex flex-wrap justify-center sm:justify-end gap-3 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">Home</a>
            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">Shop</a>
            <a href="{{ route('login') }}" class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">Login</a>
        </div>
    </div>
</footer>
