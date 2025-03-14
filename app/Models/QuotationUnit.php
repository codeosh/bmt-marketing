<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationUnit extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationUnitFactory> */
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'quotation_units';

    // Specifies which columns are mass-assignable (prevents mass-assignment vulnerabilities)
    protected $fillable = ['units'];
}
