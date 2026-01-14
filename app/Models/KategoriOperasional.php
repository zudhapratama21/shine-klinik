<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriOperasional extends Model
{
    use HasFactory;
    protected $table = 'kategori_operasionals';
    protected $fillable = [
        'nama'
    ];
    
    public function operasional()
    {
        return $this->hasMany(Operasional::class, 'kategorioperasional_id');
    }
}
