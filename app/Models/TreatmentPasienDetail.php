<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentPasienDetail extends Model
{
    use HasFactory;
    protected $table = 'treatment_pasien_details';
    protected $fillable = [
        'treatment_id',
        'treatmentpasien_id',
        'harga',
        'diskon_persen',
        'diskon_rupiah',
        'total'
    ];

   
    public function treatmentpasien()
    {
        return $this->belongsTo(TreatmentPasien::class, 'treatmentpasien_id', 'id');
    }

     public function treatment()
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

}
