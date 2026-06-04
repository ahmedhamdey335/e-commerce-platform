<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard / storefront home.
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isSeller()) {
                return redirect()->route('seller.dashboard');
            }
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }
        $featuredProducts = Product::with('categories')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        $categories = Category::take(6)->get();

        return view('welcome', compact('featuredProducts', 'categories'));
    }
}
