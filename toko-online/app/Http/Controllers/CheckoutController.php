<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect('/keranjang')
                ->withErrors([
                    'checkout' => 'Keranjang masih kosong.',
                ]);
        }

        $products = Product::whereIn(
            'id_barang',
            array_keys($cart)
        )->get()->keyBy('id_barang');

        $total = 0;

        foreach ($cart as $id => $jumlah) {
            $product = $products->get($id);

            if (!$product) {
                continue;
            }

            $total += $product->harga * $jumlah;
        }

        return view('checkout.index', compact(
            'cart',
            'products',
            'total'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => [
                'required',
                'string',
            ],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect('/keranjang')
                ->withErrors([
                    'checkout' => 'Keranjang masih kosong.',
                ]);
        }

        try {

            DB::transaction(function () use (
                $request,
                $cart
            ) {

                $products = Product::whereIn(
                    'id_barang',
                    array_keys($cart)
                )
                ->lockForUpdate()
                ->get()
                ->keyBy('id_barang');

                $total = 0;

                foreach ($cart as $id => $jumlah) {

                    $product = $products->get($id);

                    if (!$product) {
                        throw new \Exception(
                            'Produk tidak ditemukan.'
                        );
                    }

                    if ($jumlah <= 0) {
                        throw new \Exception(
                            'Jumlah pembelian tidak valid.'
                        );
                    }

                    if ($jumlah > $product->stok) {
                        throw new \Exception(
                            "Stok {$product->nama_barang} tidak mencukupi."
                        );
                    }

                    $total +=
                        $product->harga * $jumlah;
                }

                $orderId =
                    'ORD' . Str::upper(
                        Str::random(12)
                    );

                $order = Order::create([
                    'id_order' => $orderId,
                    'id_user' => Auth::id(),
                    'tanggal_order' => now(),
                    'total_harga' => $total,
                    'alamat_pengiriman' =>
                        $request->alamat_pengiriman,
                ]);

                foreach ($cart as $id => $jumlah) {

                    $product = $products->get($id);

                    OrderDetail::create([
                        'id_order' => $order->id_order,
                        'id_barang' => $product->id_barang,
                        'harga_satuan' => $product->harga,
                        'Jumlah_beli' => $jumlah,
                    ]);

                    $product->stok -= $jumlah;
                    $product->save();
                }

                session()->forget('cart');

                session()->put(
                    'checkout_order_id',
                    $order->id_order
                );
            });

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'checkout' => $e->getMessage(),
                ])
                ->withInput();
        }

        return redirect('/riwayat')
            ->with(
                'success',
                'Checkout berhasil. Pesanan telah dibuat.'
            );
    }
}