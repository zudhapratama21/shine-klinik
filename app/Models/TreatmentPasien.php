<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentPasien extends Model
{
    use HasFactory;
    protected $table = 'treatment_pasiens';
    protected $fillable = [
        'kode',
        'pasien_id',
        'dokter_id',
        'tanggal',
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
        return $this->hasMany(TreatmentPasienDetail::class, 'treatmentpasien_id');
    }

      public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }
}
