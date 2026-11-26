<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        collect([
            ['Buah Tropis', '🍍', 'Pisang, mangga, nanas, pepaya, dan alpukat khas tropis.'],
            ['Jeruk', '🍊', 'Jeruk segar dengan kadar air tinggi.'],
            ['Apel & Anggur', '🍎', 'Buah renyah dan manis untuk ritel & hotel.'],
            ['Melon & Semangka', '🍉', 'Buah besar penuh air, favorit katering dan restoran.'],
            ['Berry & Eksotis', '🍓', 'Stroberi, buah naga, dan jambu kristal.'],
        ])->each(fn (array $c) => Category::updateOrCreate(
            ['slug' => Str::slug($c[0])],
            ['name' => $c[0], 'icon' => $c[1], 'description' => $c[2]]
        ));
    }
}
