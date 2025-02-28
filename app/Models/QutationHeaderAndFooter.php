<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QutationHeaderAndFooter extends Model
{
    /** @use HasFactory<\Database\Factories\QutationHeaderAndFooterFactory> */
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'quotation_header_and_footers';

    // Specifies which columns are mass-assignable (prevents mass-assignment vulnerabilities)
    protected $fillable = ['header_image', 'footer_image'];
}
