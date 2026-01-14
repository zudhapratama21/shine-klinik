<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'pembelian_details';
    protected $fillable = [
        'pembelian_id',
        'produk_id',
        'qty',
        'harga_beli',
        'diskon_persen',
        'diskon_rupiah',
        'subtotal',
        'total',
        'ongkos_kirim',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id');
    }
}
