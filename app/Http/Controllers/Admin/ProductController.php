<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $trashed = $request->boolean('trashed');

        $products = Product::with('category')
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->when($request->query('q'), fn ($q, $search) => $q->where('product_name', 'like', "%{$search}%"))
            ->orderBy('product_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'trashed' => $trashed,
            'trashedCount' => Product::onlyTrashed()->count(),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(['grade' => 'A', 'ripeness_percentage' => 80, 'stock' => 0]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['slug'] = Product::uniqueSlug($data['product_name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['slug'] = Product::uniqueSlug($data['product_name'], $product->id);

        if ($request->hasFile('image')) {
            $this->deleteImage($product);
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteImage($product);
            $data['image'] = null;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /** Soft delete: produk disembunyikan, bisa dipulihkan dari tab "Terhapus". */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('success', "Produk \"{$product->product_name}\" dipindahkan ke daftar terhapus.");
    }

    public function restore(int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return back()->with('success', "Produk \"{$product->product_name}\" berhasil dipulihkan.");
    }

    private function deleteImage(Product $product): void
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
    }
}
