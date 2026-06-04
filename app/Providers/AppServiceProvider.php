<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use App\Models\Category;
use App\Models\CartItem;
use App\Policies\ProductPolicy;
use App\Policies\OrderPolicy;
use App\Policies\AddressPolicy;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Address::class, AddressPolicy::class);

        View::composer('layouts.app', function ($view) {
            $layoutCategories = Category::orderBy('name')->get();
            $cartCount = Auth::check() ? CartItem::where('user_id', Auth::id())->sum('quantity') : 0;

            $view->with(compact('layoutCategories', 'cartCount'));
        });
    }
}
