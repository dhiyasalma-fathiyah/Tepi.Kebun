<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Dhiya Salma Fathiyah', 'role' => 'Developer', 'bio' => 'NIM: 2410120007'],
            ['name' => 'Muhammad Briliant',    'role' => 'Developer', 'bio' => 'NIM: 2410120009'],
        ];

        foreach ($members as $member) {
            TeamMember::create($member);
        }
    }
}
