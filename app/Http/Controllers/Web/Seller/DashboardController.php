<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalProducts = Product::where('user_id', $user->id)->count();
        
        // Orders containing products belonging to this seller
        $orderItems = OrderItem::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('order')->get();
        
        $totalOrders = $orderItems->pluck('order_id')->unique()->count();
        $totalRevenue = $orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Recent orders
        $recentOrders = Order::whereIn('id', $orderItems->pluck('order_id')->unique())
            ->with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders'));
    }
}
