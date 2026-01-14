<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operasional extends Model
{
    use HasFactory;
    protected $table = 'operasionals';
    protected $fillable = [
        'kategorioperasional_id',
        'nama',
        'nominal',
        'tanggal'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriOperasional::class, 'kategorioperasional_id', 'id');
    }
}
