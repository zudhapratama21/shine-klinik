<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTreatment extends Model
{
    use HasFactory;
    protected $table = 'kategori_treatments';
    protected $fillable = [
        'name',        
        'file',
        'slug'
    ];

    public function treatment()
    {
        return $this->hasMany(Treatment::class, 'kategoritreatment_id');
    }
}
