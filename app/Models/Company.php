<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = "companies";

    protected $fillable = [
        'industry_group',
        'company_name',
        'contact_person',
        'contact_number',
        'email',
        'address',
        'other_digi_contact_platform',
        'terms_of_payment',
        'contacted',
        'to_recontact',
        'to_email',
        'to_propose',
        'visited',
        'ec_ordered1',
        'problematic',
        'acct_active',
        'notes',
        'description',
        'status',
    ];
}
