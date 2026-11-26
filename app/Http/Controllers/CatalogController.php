<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $all = Product::with('category')->orderBy('product_name')->get();

        $search = trim((string) $request->query('q', ''));
        $categoryId = $request->query('kategori');
        $grade = $request->query('grade');

        // Filter katalog memakai Laravel Collection pada hasil query Eloquent.
        $products = $all
            ->when($search !== '', fn ($c) => $c->filter(
                fn (Product $p) => str_contains(mb_strtolower($p->product_name), mb_strtolower($search))
            ))
            ->when($categoryId, fn ($c) => $c->where('category_id', (int) $categoryId))
            ->when(in_array($grade, ['A', 'B'], true), fn ($c) => $c->where('grade', $grade))
            ->values();

        // Jumlah produk per kategori untuk chip filter.
        $categoryCounts = $all->countBy('category_id');
        $categories = Category::orderBy('name')->get()
            ->map(function (Category $c) use ($categoryCounts) {
                $c->products_total = $categoryCounts->get($c->id, 0);

                return $c;
            });

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'totalAll' => $all->count(),
            'filters' => compact('search', 'categoryId', 'grade'),
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');

        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->inStock()
            ->get()
            ->take(3);

        return view('products.show', compact('product', 'related'));
    }
}
