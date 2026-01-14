<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['nama', 'kode', 'harga', 'stok', 'description', 'kategoriproduk_id', 'image', 'berat', 'status'];

    public function kategoriproduk()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategoriproduk_id');
    }
}
