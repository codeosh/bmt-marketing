<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guides extends Model
{
    /** @use HasFactory<\Database\Factories\GuidesFactory> */
    use HasFactory;

    protected $table = 'tbl_guides';

    protected $fillable = ['pname', 'kind', 'content'];
}
