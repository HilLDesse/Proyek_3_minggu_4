<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();

        return view('barang.index', compact('barangs'));
    }

    public function keranjang()
    {
        $barangs = Barang::all();

        return view('barang.keranjang', compact('barangs'));
    }
}