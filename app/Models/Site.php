<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'site_name',
        'customer_id',
        'tax_code_id',
        'country',
        'site_address',
        'site_address_2',
        'city',
        'state_province',
        'zip_postal_code',
        'county',
        'latitude',
        'longitude',
        'notes',
        'internal_notes',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function additionalContacts()
    {
        return $this->hasMany(AdditionalContact::class);
    }

    public function taxCode()
    {
        return $this->belongsTo(TaxCode::class);
    }

    
}
