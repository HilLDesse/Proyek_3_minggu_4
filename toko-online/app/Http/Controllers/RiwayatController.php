<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $orders = Order::with('details.product')
            ->where('id_user', Auth::id())
            ->orderByDesc('tanggal_order')
            ->get();

        return view('riwayat.index', compact('orders'));
    }
}