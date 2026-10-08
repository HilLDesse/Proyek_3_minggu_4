<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'id_barang' => 'BRG001',
            'nama_barang' => 'Buku Tulis',
            'deskripsi' => 'Buku tulis bergaris untuk kebutuhan sekolah dan kuliah.',
            'harga' => 5000,
            'stok' => 20,
            'gambar' => 'buku-tulis.png',
        ]);

        Product::create([
            'id_barang' => 'BRG002',
            'nama_barang' => 'Pulpen',
            'deskripsi' => 'Pulpen tinta hitam untuk menulis sehari-hari.',
            'harga' => 3000,
            'stok' => 25,
            'gambar' => 'pulpen.png',
        ]);

        Product::create([
            'id_barang' => 'BRG003',
            'nama_barang' => 'Penggaris',
            'deskripsi' => 'Penggaris plastik 30 cm.',
            'harga' => 4000,
            'stok' => 15,
            'gambar' => 'penggaris.png',
        ]);

        Product::create([
            'id_barang' => 'BRG004',
            'nama_barang' => 'Pensil 2B',
            'deskripsi' => 'Pensil 2B untuk menulis dan menggambar.',
            'harga' => 2500,
            'stok' => 30,
            'gambar' => 'pensil-2b.png',
        ]);

        Product::create([
            'id_barang' => 'BRG005',
            'nama_barang' => 'Penghapus',
            'deskripsi' => 'Penghapus putih untuk menghapus tulisan pensil.',
            'harga' => 1500,
            'stok' => 20,
            'gambar' => 'penghapus.png',
        ]);

        Product::create([
            'id_barang' => 'BRG006',
            'nama_barang' => 'Spidol',
            'deskripsi' => 'Spidol permanen untuk berbagai kebutuhan.',
            'harga' => 7000,
            'stok' => 12,
            'gambar' => 'spidol.png',
        ]);

        Product::create([
            'id_barang' => 'BRG007',
            'nama_barang' => 'Stabilo',
            'deskripsi' => 'Highlighter untuk menandai catatan penting.',
            'harga' => 6500,
            'stok' => 18,
            'gambar' => 'stabilo.png',
        ]);

        Product::create([
            'id_barang' => 'BRG008',
            'nama_barang' => 'Kertas A4',
            'deskripsi' => 'Kertas A4 untuk mencetak dokumen.',
            'harga' => 45000,
            'stok' => 10,
            'gambar' => 'kertas-a4.png',
        ]);

        Product::create([
            'id_barang' => 'BRG009',
            'nama_barang' => 'Tempat Pensil',
            'deskripsi' => 'Tempat pensil sederhana untuk menyimpan alat tulis.',
            'harga' => 15000,
            'stok' => 10,
            'gambar' => 'tempat-pensil.png',
        ]);

        Product::create([
            'id_barang' => 'BRG010',
            'nama_barang' => 'Buku Gambar',
            'deskripsi' => 'Buku gambar untuk menggambar dan membuat sketsa.',
            'harga' => 12000,
            'stok' => 15,
            'gambar' => 'buku-gambar.png',
        ]);
    }
}