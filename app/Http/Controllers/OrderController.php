<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Support\WhatsApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Form pemesanan (gaya marketplace): pilih produk + jumlah, isi data pengiriman.
     */
    public function create(Request $request)
    {
        $products = Product::with('category')->inStock()->orderBy('product_name')->get();

        // Kelompokkan per kategori supaya mudah dipilih.
        $grouped = $products->groupBy(fn (Product $p) => $p->category->name);

        return view('orders.create', [
            'grouped' => $grouped,
            'preselected' => (int) $request->query('produk'),
            'paymentMethods' => Order::PAYMENT_METHODS,
        ]);
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $quantities = $request->quantities();

        $order = DB::transaction(function () use ($request, $quantities) {
            // Kunci baris produk agar stok tidak dipakai dua pesanan sekaligus.
            $products = Product::whereIn('id', $quantities->keys())->lockForUpdate()->get()->keyBy('id');

            $lines = $quantities->map(function (int $qty, int $id) use ($products) {
                $product = $products->get($id);

                if (! $product || $product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok '.($product->product_name ?? 'produk').' tidak mencukupi.',
                    ]);
                }

                return [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'unit_price' => $product->price_per_box,
                    'quantity' => $qty,
                    'subtotal' => $product->price_per_box * $qty,
                ];
            })->values();

            $order = Order::create([
                ...$request->safe()->except('items'),
                'status' => 'pending',
                'total_amount' => $lines->sum('subtotal'),
            ]);

            $order->items()->createMany($lines->all());

            $lines->each(fn (array $line) => Product::whereKey($line['product_id'])
                ->decrement('stock', $line['quantity']));

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat! Simpan kode pesanan Anda.');
    }

    /**
     * Konfirmasi / ringkasan pesanan.
     */
    public function show(Order $order)
    {
        $order->load('items');

        $summary = [
            'boxes' => $order->items->sum('quantity'),
            'varieties' => $order->items->count(),
        ];

        $waLink = WhatsApp::link(
            "Halo Tepi Kebun, saya {$order->customer_name}. Saya ingin konfirmasi pesanan {$order->order_code} "
            .'dengan total Rp '.number_format($order->total_amount, 0, ',', '.').'.'
        );

        return view('orders.show', compact('order', 'summary', 'waLink'));
    }
}
