<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_barang',
        'harga_satuan',
        'Jumlah_beli',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'Jumlah_beli' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'id_order',
            'id_order'
        );
    }

    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'id_barang',
            'id_barang'
        );
    }
}