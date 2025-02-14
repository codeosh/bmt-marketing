<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    /** @use HasFactory<\Database\Factories\InsightFactory> */
    use HasFactory;

    protected $table = 'tbl_insights';

    protected $fillable = ['pname', 'kind', 'content'];
}
