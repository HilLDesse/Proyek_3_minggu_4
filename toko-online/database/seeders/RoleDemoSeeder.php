<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Mempertahankan akun customer yang sudah ada.
        $customer = User::firstOrCreate(
            ['id_user' => 'USR001'],
            [
                'nama_lengkap' => 'Hilmi Kautsar',
                'email' => 'hilmi.kautsar@example.test',
                'username' => 'Hilmi',
                'password' => 'CustomerDemo123!',
                'no_hp' => '081234567890',
                'alamat' => 'Bandung',
            ]
        );

        $customer->role = 'customer';
        $customer->save();

        // Membuat akun staff untuk pengujian.
        $staff = User::firstOrCreate(
            ['id_user' => 'STF001'],
            [
                'nama_lengkap' => 'Staff Demo',
                'email' => 'staff@example.test',
                'username' => 'staff',
                'password' => 'StaffDemo123!',
                'no_hp' => '081234567891',
                'alamat' => 'Bandung',
            ]
        );

        $staff->role = 'staff';
        $staff->save();

        // Membuat akun admin melalui seeder tepercaya.
        $admin = User::firstOrCreate(
            ['id_user' => 'ADM001'],
            [
                'nama_lengkap' => 'Admin Demo',
                'email' => 'admin@example.test',
                'username' => 'admin',
                'password' => 'AdminDemo123!',
                'no_hp' => '081234567892',
                'alamat' => 'Bandung',
            ]
        );

        $admin->role = 'admin';
        $admin->save();
    }
}