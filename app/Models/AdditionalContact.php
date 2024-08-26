<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'title',
        'email',
        'phone',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
