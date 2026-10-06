<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'budi',
            'password' => 'rahasia123',
            'nama_lengkap' => 'Budi Santoso',
        ]);

        User::create([
            'username' => 'andi',
            'password' => 'password123',
            'nama_lengkap' => 'Andi Pratama',
        ]);
    }
}