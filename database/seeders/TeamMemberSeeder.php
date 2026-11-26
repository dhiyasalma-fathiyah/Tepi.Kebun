<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::updateOrCreate(['name' => 'Dhiya Salma Fathiyah'], [
            'role' => 'Developer',
            'bio' => 'NIM: 2410120007',
        ]);

        TeamMember::updateOrCreate(['name' => 'Muhammad Briliant'], [
            'role' => 'Developer',
            'bio' => 'NIM: 2410120009',
        ]);
    }
}
