<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(Request $request): View
    {
        $categories = Category::orderBy('sort_order')->get();
        $categorySlug = $request->query('category');

        $productsQuery = Product::active()->latest();

        if ($categorySlug && $categorySlug !== 'all') {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $productsQuery->where('category_id', $category->id);
            }
        }

        $products = $productsQuery->get();

        return view('home', compact('categories', 'products', 'categorySlug'));
    }

    /**
     * Display the product detail page.
     */
    public function show(Product $product): View
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}
