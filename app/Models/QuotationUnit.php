<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationUnit extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationUnitFactory> */
    use HasFactory;

    protected $table = 'quotation_units';
    protected $fillable = ['units'];
}
