<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricelist extends Model
{
    use HasFactory;

    protected $table = 'pricelists'; // Ensure this matches your actual database table name

    protected $fillable = ['pname', 'kind', 'content']; // Add any columns that should be mass-assignable
}
