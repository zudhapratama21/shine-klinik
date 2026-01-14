<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProduct extends Model
{
    use HasFactory;
    protected $table = 'history_products';
    protected $fillable = [
        'produk_id',
        'kode_transaksi',
        'jenis',
        'qty',
        'stok',
    ];

  
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    
    
}
