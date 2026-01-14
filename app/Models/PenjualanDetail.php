<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;
    protected $table = "penjualan_details";
    protected $fillable = [ 
        'penjualan_id',
        'produk_id',
        'qty',
        'harga_jual',
        'diskon_persen',
        'diskon_rupiah',
        'ongkos_kirim',
        'subtotal',
        'total'
    ];

    
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }
}
