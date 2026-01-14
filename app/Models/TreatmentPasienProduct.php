<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentPasienProduct extends Model
{
    use HasFactory;
    protected $table = 'treatment_pasien_products';
    protected $fillable = [
        'product_id',
        'treatmentpasien_id',
        'qty'
    ];

   
    public function treatmentpasien()
    {
        return $this->belongsTo(TreatmentPasien::class, 'treatmentpasien_id', 'id');
    }

   
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
