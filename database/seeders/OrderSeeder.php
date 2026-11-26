<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Beberapa pesanan contoh supaya dashboard admin tidak kosong.
     */
    public function run(): void
    {
        if (Order::exists()) {
            return;
        }

        $products = Product::all()->keyBy('slug');

        // [nama, kota, status, hari lalu, [slug => jumlah]]
        $samples = [
            ['Super Indo Cabang Bandung', 'Bandung', 'completed', 6, ['pisang-cavendish' => 20, 'jeruk-siam' => 10]],
            ['Toko Buah Segar', 'Jakarta Selatan', 'completed', 4, ['mangga-harum-manis' => 8, 'apel-fuji' => 6]],
            ['Restoran Nusantara', 'Surabaya', 'shipped', 2, ['semangka-merah' => 12, 'melon-honey-globe' => 5]],
            ['Hotel Melati', 'Yogyakarta', 'processing', 1, ['anggur-red-globe' => 4, 'stroberi-lembang' => 3]],
            ['Kafe Kebun Kita', 'Bandung', 'pending', 0, ['alpukat-mentega' => 6, 'buah-naga-merah' => 4]],
        ];

        foreach ($samples as $i => [$name, $city, $status, $daysAgo, $lines]) {
            $items = collect($lines)->map(function (int $qty, string $slug) use ($products) {
                $product = $products[$slug];

                return [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'unit_price' => $product->price_per_box,
                    'quantity' => $qty,
                    'subtotal' => $product->price_per_box * $qty,
                ];
            })->values();

            $order = Order::create([
                'customer_name' => $name,
                'phone' => '08123456'.str_pad((string) (7000 + $i), 4, '0', STR_PAD_LEFT),
                'email' => null,
                'address' => 'Jl. Contoh Raya No. '.(10 + $i).', '.$city,
                'city' => $city,
                'postal_code' => '40'.str_pad((string) (100 + $i), 3, '0', STR_PAD_LEFT),
                'payment_method' => $i % 2 ? 'cod' : 'transfer',
                'status' => $status,
                'total_amount' => $items->sum('subtotal'),
            ]);
            $order->items()->createMany($items->all());

            $order->forceFill(['created_at' => now()->subDays($daysAgo)])->save();
        }
    }
}
