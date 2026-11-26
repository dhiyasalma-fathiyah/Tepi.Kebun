<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $trashed = $request->boolean('trashed');
        $status = $request->query('status');

        $orders = Order::withCount('items')
            ->when($trashed, fn ($q) => $q->onlyTrashed())
            ->when(array_key_exists((string) $status, Order::STATUSES), fn ($q) => $q->where('status', $status))
            ->when($request->query('q'), fn ($q, $s) => $q->where(
                fn ($w) => $w->where('order_code', 'like', "%{$s}%")->orWhere('customer_name', 'like', "%{$s}%")
            ))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Jumlah pesanan per status untuk tab filter.
        $counts = Order::all()->countBy('status');

        return view('admin.orders.index', [
            'orders' => $orders,
            'counts' => $counts,
            'status' => $status,
            'trashed' => $trashed,
            'trashedCount' => Order::onlyTrashed()->count(),
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ], [], ['status' => 'status']);

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diubah.');
        }

        DB::transaction(function () use ($order, $data) {
            // Pembatalan mengembalikan stok produk.
            if ($data['status'] === 'cancelled') {
                $order->load('items')->items
                    ->filter(fn ($item) => $item->product_id)
                    ->each(fn ($item) => Product::withTrashed()->whereKey($item->product_id)
                        ->increment('stock', $item->quantity));
            }

            $order->update(['status' => $data['status']]);
        });

        return back()->with('success', 'Status pesanan diperbarui menjadi "'.$order->status_label.'".');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', "Pesanan {$order->order_code} dipindahkan ke daftar terhapus.");
    }

    public function restore(int $id): RedirectResponse
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return back()->with('success', "Pesanan {$order->order_code} berhasil dipulihkan.");
    }
}
