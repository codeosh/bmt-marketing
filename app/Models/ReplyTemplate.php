<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReplyTemplate extends Model
{
    //
    use HasFactory;

    protected $table = 'tbl_reply_template';

    protected $fillable = ['pname', 'kind', 'content'];
}
