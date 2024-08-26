<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_date',
        'user_id',
        'service_location_id',
        'payment_term_id',
        'due_date',
        'po_number',
        'address_name',
        'address',
        'address_2',
        'city',
        'state_province',
        'zip_postal_code',
        'invoice_subtotal',
        'discount_value',
        'tax_code_id',
        'message_displayed_on_invoice',
        'internal_memo',
        'attachments',
        'preferred_communication',
        'online_payment',
    ];

    // Relationship with the Customer model
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship with the User model (formerly 'clerk')
    public function clerk()
    {
        return $this->belongsTo(User::class, 'user_id');  // Updated to use 'user_id'
    }

    // Relationship with the Site model for service location
    public function serviceLocation()
    {
        return $this->belongsTo(Site::class, 'service_location_id');
    }

    // Relationship with the PaymentTerm model
    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    // Relationship with the TaxCode model
    public function taxCode()
    {
        return $this->belongsTo(TaxCode::class);
    }

    // Many-to-Many relationship with the Service model
    public function services()
    {
        return $this->belongsToMany(Service::class, 'invoice_services')
            ->withPivot('service_amount')
            ->withTimestamps();
    }
}
