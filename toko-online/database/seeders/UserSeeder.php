<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_user' => 'USR001',
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'username' => 'budi',
            'password' => Hash::make('rahasia123'),
            'no_hp' => '081234567890',
            'alamat' => 'Bandung',
        ]);
    }
}