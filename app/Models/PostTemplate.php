<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTemplate extends Model
{
    use HasFactory;

    protected $table = "tbl_posttemplate";

    protected $fillable = [
        'unitcode',
        'pname',
        'kind',
        'content',
    ];
}
