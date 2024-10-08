<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'company_organization',
        'first_name',
        'emails',
        'tax_code_id',
        'payment_term_id',
        'last_name',
        'preferred_billing_communication',
        'phone',
        'secondary_phone',
        'fax',
        'country',
        'address',
        'address_2',
        'city',
        'state_province',
        'zip_postal_code',
        'county',
        'customer_type',
        'customer_since',
        'heard_about_us',
        'notes',
        'internal_notes',
    ];


    public function additionalContacts()
    {
        return $this->hasMany(AdditionalContact::class);
    }

    public function taxCode()
    {
        return $this->belongsTo(TaxCode::class);
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
