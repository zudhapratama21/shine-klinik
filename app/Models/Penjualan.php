<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualans';
    protected $fillable = [
        'kode',
        'tanggal',
        'pasien_id',
        'subtotal',
        'diskon',
        'ppn',
        'grandtotal',
        'keterangan'
    ];

   
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }
    
    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

}
