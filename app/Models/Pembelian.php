<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table  = 'pembelians';
    protected $fillable = [
        'kode',
        'tanggal',
        'supplier_id',
        'subtotal',
        'diskon',
        'ppn',
        'keterangan',
        'kode_supplier',
        'grandtotal'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
    
}