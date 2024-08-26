<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_code',
        'is_taxable',
        'is_surcharge',
        'billing_period',
        'rate',
        'notes',
    ];
}
