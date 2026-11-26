<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->get();
        $products = Product::with('category')->get();

        $activeOrders = $orders->where('status', '!=', 'cancelled');

        $stats = [
            'revenue' => $activeOrders->sum('total_amount'),
            'orders' => $orders->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'stock' => $products->sum('stock'),
            'unread' => Contact::where('is_read', false)->count(),
        ];

        // Jumlah pesanan per status.
        $byStatus = collect(Order::STATUSES)->map(
            fn (array $meta, string $status) => [
                'label' => $meta[0],
                'color' => $meta[1],
                'total' => $orders->where('status', $status)->count(),
            ]
        );

        // Pendapatan 7 hari terakhir (hari tanpa pesanan = 0).
        $perDay = $activeOrders->groupBy(fn (Order $o) => $o->created_at->format('Y-m-d'))
            ->map(fn ($group) => $group->sum('total_amount'));

        $revenueWeek = collect(range(6, 0))->mapWithKeys(function (int $daysAgo) use ($perDay) {
            $date = now()->subDays($daysAgo);

            return [$date->format('d M') => $perDay->get($date->format('Y-m-d'), 0)];
        });

        // 5 produk terlaris (jumlah box).
        $topProducts = OrderItem::whereIn('order_id', $activeOrders->pluck('id'))->get()
            ->groupBy('product_name')
            ->map(fn ($rows) => $rows->sum('quantity'))
            ->sortDesc()
            ->take(5);

        // Stok menipis (<= 30 box).
        $lowStock = $products->filter(fn (Product $p) => $p->stock <= 30)->sortBy('stock')->take(5);

        $latestOrders = $orders->sortByDesc('created_at')->take(5);

        return view('admin.dashboard', compact(
            'stats', 'byStatus', 'revenueWeek', 'topProducts', 'lowStock', 'latestOrders'
        ));
    }
}
