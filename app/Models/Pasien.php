<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'pasiens';
    protected $fillable = [
        'kode_pasien',
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'nomor_hp',
        'status',
        'email',
        'alamat',
        'instagram',
        'tiktok',
    ];

    public function administrasi(): HasMany
    {
        return $this->hasMany(Administrasi::class);
    }
}
