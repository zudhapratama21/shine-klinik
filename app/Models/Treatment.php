<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    protected $table = 'treatments';
    protected $fillable = [
        'kode',
        'nama',
        'kategoritreatment_id',
        'harga',
        'deskripsi',
        'gambar',
        'status',
    ];

    public function kategoritreatment()
    {
        return $this->belongsTo(KategoriTreatment::class, 'kategoritreatment_id');
    }

    
}
