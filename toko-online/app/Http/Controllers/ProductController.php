<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function addToCart(Request $request, Product $product)
    {
        if ($product->stok <= 0) {
            return back()->withErrors([
                'cart' => 'Stok barang habis.',
            ]);
        }

        $cart = session('cart', []);

        $id = $product->id_barang;

        $jumlahSekarang = $cart[$id] ?? 0;

        if ($jumlahSekarang + 1 > $product->stok) {
            return back()->withErrors([
                'cart' => 'Jumlah yang dibeli tidak boleh melebihi stok.',
            ]);
        }

        $cart[$id] = $jumlahSekarang + 1;

        session()->put('cart', $cart);

        return back()->with('success', 'Barang berhasil dimasukkan ke keranjang.');
    }

    public function cart()
    {
        $cart = session('cart', []);

        $products = Product::whereIn(
            'id_barang',
            array_keys($cart)
        )->get()->keyBy('id_barang');

        return view('cart.index', compact('cart', 'products'));
    }

    public function increase(Request $request, Product $product)
    {
        $cart = session('cart', []);

        $id = $product->id_barang;

        $jumlahSekarang = $cart[$id] ?? 0;

        if ($jumlahSekarang >= $product->stok) {
            return back()->withErrors([
                'cart' => 'Jumlah yang dibeli tidak boleh melebihi stok.',
            ]);
        }

        $cart[$id] = $jumlahSekarang + 1;

        session()->put('cart', $cart);

        return back();
    }

    public function decrease(Request $request, Product $product)
    {
        $cart = session('cart', []);

        $id = $product->id_barang;

        if (!isset($cart[$id])) {
            return back();
        }

        $cart[$id]--;

        if ($cart[$id] <= 0) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return back();
    }

    public function remove(Request $request, Product $product)
    {
        $cart = session('cart', []);

        unset($cart[$product->id_barang]);

        session()->put('cart', $cart);

        return back();
    }

    public function clearCart(Request $request)
    {
        session()->forget('cart');

        return back();
    }
}