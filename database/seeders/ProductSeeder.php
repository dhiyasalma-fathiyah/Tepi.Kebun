<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['product_name' => 'Pisang Cavendish', 'category' => 'Pisang', 'grade' => 'A', 'ripeness_percentage' => 80,
             'weight_per_box' => 13, 'price_per_box' => 185000, 'stock' => 120,
             'description' => 'Pisang kualitas superior, manis, dengan warna kuning cerah merata.'],
            ['product_name' => 'Jeruk Siam', 'category' => 'Jeruk', 'grade' => 'A', 'ripeness_percentage' => 90,
             'weight_per_box' => 10, 'price_per_box' => 150000, 'stock' => 200,
             'description' => 'Jeruk dengan kandungan air melimpah dan rasa manis segar alami.'],
            ['product_name' => 'Mangga Harum Manis', 'category' => 'Mangga', 'grade' => 'B', 'ripeness_percentage' => 75,
             'weight_per_box' => 15, 'price_per_box' => 210000, 'stock' => 80,
             'description' => 'Mangga manis aromatis, cocok untuk konsumsi langsung maupun olahan.'],
            ['product_name' => 'Pisang Raja', 'category' => 'Pisang', 'grade' => 'B', 'ripeness_percentage' => 70,
             'weight_per_box' => 12, 'price_per_box' => 140000, 'stock' => 60,
             'description' => 'Pisang raja untuk olahan gorengan dan kolak.'],
            ['product_name' => 'Jeruk Mandarin', 'category' => 'Jeruk', 'grade' => 'A', 'ripeness_percentage' => 85,
             'weight_per_box' => 10, 'price_per_box' => 175000, 'stock' => 45,
             'description' => 'Jeruk mandarin mudah dikupas dengan rasa manis seimbang.'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
