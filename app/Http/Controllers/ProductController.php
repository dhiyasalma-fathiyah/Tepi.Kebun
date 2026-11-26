<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->search($request->query('q'))
            ->grade($request->query('grade'))
            ->latest()
            ->get();

        return view('products.index', [
            'products'  => $products,
            'stats'     => $this->summarize($products),
            'isTrashed' => false,
        ]);
    }

    public function create(): View
    {
        return view('products.create', ['product' => new Product()]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product): View
    {
        $product->loadCount('contacts');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.show', $product)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // Soft delete: mengisi kolom deleted_at tanpa menghapus permanen
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk dipindahkan ke sampah.');
    }

    public function trashed(): View
    {
        $products = Product::onlyTrashed()->latest('deleted_at')->get();

        return view('products.index', [
            'products'  => $products,
            'stats'     => $this->summarize($products),
            'isTrashed' => true,
        ]);
    }

    public function restore(int $id): RedirectResponse
    {
        Product::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dipulihkan.');
    }

    /** Ringkasan statistik memakai Laravel Collection. */
    private function summarize(Collection $products): Collection
    {
        return collect([
            'total'     => $products->count(),
            'stock'     => $products->sum('stock'),
            'avg_price' => (float) $products->avg('price_per_box'),
            'by_grade'  => $products->countBy('grade'),
            'category'  => $products->pluck('category')->unique()->sort()->values(),
        ]);
    }
}
