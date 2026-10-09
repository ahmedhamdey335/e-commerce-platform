<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders'));
    }

    public function products(Request $request)
    {
        $products = Product::with(['categories', 'seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.products', compact('products'));
    }

    public function categories(Request $request)
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.categories', compact('categories'));
    }

    public function orders(Request $request)
    {
        $orders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.orders', compact('orders'));
    }

    public function users(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.users', compact('users'));
    }
}
