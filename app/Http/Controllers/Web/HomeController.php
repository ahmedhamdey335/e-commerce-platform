<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard / storefront home.
     */
    public function index()
    {
        $featuredProducts = Product::with('categories')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        $categories = Category::take(6)->get();

        return view('welcome', compact('featuredProducts', 'categories'));
    }
}
