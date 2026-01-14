<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokter extends Model
{
    use HasFactory;
    protected $table = 'dokters';
    protected $fillable = [
        'user_id',
        'kode_dokter',
        'nama_dokter',
        'foto',
        'nomor_hp',
        'instagram',
        'tiktok',
        'status',
        'tanggal_lahir',
        'alamat'
    ];

    
    public function administrasi(): HasMany
    {
        return $this->hasMany(Administrasi::class);
    }

    public function poli(): HasMany
    {
        return $this->hasMany(Poli::class);
    }
}
