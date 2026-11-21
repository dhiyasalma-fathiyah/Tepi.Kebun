<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'grade' => 'required|in:A,B',
            'ripeness_percentage' => 'required|integer|min:0|max:100',
            'weight_per_box' => 'required|numeric|min:0',
            'price_per_box' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        Product::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'sometimes|required|string|max:100',
            'category' => 'sometimes|required|string|max:50',
            'grade' => 'sometimes|required|in:A,B',
            'ripeness_percentage' => 'sometimes|required|integer|min:0|max:100',
            'weight_per_box' => 'sometimes|required|numeric|min:0',
            'price_per_box' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
    }

    // Soft delete: mengisi kolom deleted_at tanpa menghapus permanen
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus sementara.');
    }

    public function trashed()
    {
        $trashedProducts = Product::onlyTrashed()->get();
        return view('product', [
            'products' => $trashedProducts,
            'isTrashed' => true,
        ]);
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->back()->with('success', 'Produk berhasil dipulihkan.');
    }
}