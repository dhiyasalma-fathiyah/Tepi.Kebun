<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        // [nama, kategori, grade, kematangan %, berat/box kg, harga/box, stok, deskripsi]
        $data = [
            ['Pisang Cavendish', 'Buah Tropis', 'A', 80, 18, 360000, 120, 'Pisang kualitas superior, manis, kuning cerah merata. Siap pajang dalam 2-3 hari.'],
            ['Mangga Harum Manis', 'Buah Tropis', 'B', 70, 15, 450000, 80, 'Mangga manis beraroma kuat, cocok untuk konsumsi langsung maupun olahan jus.'],
            ['Nanas Madu', 'Buah Tropis', 'A', 85, 12, 220000, 60, 'Nanas madu rendah serat dengan rasa manis segar, tanpa rasa gatal di lidah.'],
            ['Pepaya California', 'Buah Tropis', 'A', 75, 14, 180000, 90, 'Pepaya daging oranye tebal, manis, dan tahan simpan lebih lama.'],
            ['Alpukat Mentega', 'Buah Tropis', 'A', 70, 10, 340000, 45, 'Alpukat berdaging lembut dan creamy, favorit kafe dan restoran.'],
            ['Jeruk Siam', 'Jeruk', 'A', 85, 15, 280000, 150, 'Jeruk dengan kandungan air melimpah dan rasa manis segar alami.'],
            ['Jeruk Medan', 'Jeruk', 'A', 70, 15, 310000, 100, 'Jeruk Medan ukuran M-L, kulit tipis, rasa manis-asam seimbang.'],
            ['Apel Fuji', 'Apel & Anggur', 'B', 70, 10, 450000, 70, 'Apel renyah dan manis dengan warna merah merata.'],
            ['Anggur Red Globe', 'Apel & Anggur', 'A', 90, 8, 520000, 40, 'Anggur butir besar, renyah, manis, cocok untuk buffet hotel.'],
            ['Semangka Merah', 'Melon & Semangka', 'A', 90, 20, 150000, 110, 'Semangka merah tanpa biji besar, sangat segar dan manis.'],
            ['Melon Honey Globe', 'Melon & Semangka', 'A', 85, 16, 260000, 55, 'Melon kulit jaring halus dengan daging manis beraroma madu.'],
            ['Stroberi Lembang', 'Berry & Eksotis', 'A', 90, 4, 400000, 25, 'Stroberi segar dari dataran tinggi Lembang, kemasan punnet.'],
            ['Buah Naga Merah', 'Berry & Eksotis', 'B', 80, 10, 300000, 35, 'Buah naga daging merah, kaya antioksidan, cocok untuk smoothie.'],
            ['Jambu Kristal', 'Berry & Eksotis', 'B', 75, 12, 240000, 28, 'Jambu kristal nyaris tanpa biji dengan tekstur renyah.'],
        ];

        collect($data)->each(function (array $row) use ($categories) {
            [$name, $category, $grade, $ripeness, $weight, $price, $stock, $description] = $row;
            $slug = Str::slug($name);

            Product::updateOrCreate(['slug' => $slug], [
                'category_id' => $categories[$category],
                'product_name' => $name,
                'grade' => $grade,
                'ripeness_percentage' => $ripeness,
                'weight_per_box' => $weight,
                'price_per_box' => $price,
                'stock' => $stock,
                'description' => $description,
                'image' => $this->copyImage($slug),
            ]);
        });
    }

    /**
     * Salin foto contoh ke storage/app/public/products (diakses via `storage:link`).
     */
    private function copyImage(string $slug): ?string
    {
        $source = database_path("seeders/images/{$slug}.svg");

        if (! File::exists($source)) {
            return null;
        }

        $path = "products/{$slug}.svg";
        Storage::disk('public')->put($path, File::get($source));

        return $path;
    }
}
