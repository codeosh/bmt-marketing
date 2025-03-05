<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QoutotaionTermsCondtionRemarks extends Model
{
    /** @use HasFactory<\Database\Factories\QoutotaionTermsCondtionRemarksFactory> */
    use HasFactory;

    protected $table = 'qoutotaion_terms_condtion_remarks';

    protected $fillable = [
        'customer_id',
        'condition',          // Year
        'warranty',           // 5yrs
        'vat',                // Major parts (12%)
        'availability',       // Excluded
        'rd',                 // Onstock
        'price_effectivity',  // 1 Week
    ];
}
