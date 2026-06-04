<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('categories');

        $seller = null;

        if ($request->has('seller')) {
            $sellerId = $request->seller;
            $seller = User::find($sellerId);
            $query->where('user_id', $sellerId);
        }

        // Apply category filter if present
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Apply search query
        if ($request->has('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories', 'seller'));
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::with(['categories', 'seller'])->findOrFail($id);
        
        $relatedProducts = Product::whereHas('categories', function ($q) use ($product) {
            $categoryIds = $product->categories->pluck('id');
            $q->whereIn('category_id', $categoryIds);
        })
        ->where('id', '!=', $product->id)
        ->take(4)
        ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
