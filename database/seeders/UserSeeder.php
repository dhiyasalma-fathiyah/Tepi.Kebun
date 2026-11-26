<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin (ubah lewat ADMIN_EMAIL / ADMIN_PASSWORD di .env).
        $admin = User::firstOrNew(['email' => config('tepikebun.admin_email')]);
        $admin->name = 'Admin Tepi Kebun';
        $admin->password = env('ADMIN_PASSWORD', 'password123'); // otomatis di-hash oleh cast
        $admin->is_admin = true;
        $admin->save();

        // Akun pengunjung biasa — untuk menguji bahwa non-admin ditolak.
        $visitor = User::firstOrNew(['email' => 'user@tepikebun.test']);
        $visitor->name = 'Pengguna Biasa';
        $visitor->password = 'password123';
        $visitor->is_admin = false;
        $visitor->save();
    }
}
