<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->inStock()->get();

        // Buah unggulan: Grade A dengan kematangan tertinggi.
        $featured = $products
            ->filter(fn (Product $p) => $p->grade === 'A')
            ->sortByDesc('ripeness_percentage')
            ->take(4)
            ->values();

        $categories = Category::withCount('products')
            ->get()
            ->filter(fn (Category $c) => $c->products_count > 0);

        $stats = [
            'varieties' => $products->count(),
            'totalStock' => $products->sum('stock'),
            'gradeA' => $products->where('grade', 'A')->count(),
        ];

        return view('home', compact('featured', 'categories', 'stats'));
    }
}
