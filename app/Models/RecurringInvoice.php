<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringInvoice extends Model
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
        'billing_type',
        'interval_unit',
        'interval_value',
        'start_date',
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function clerk()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceLocation()
    {
        return $this->belongsTo(Site::class, 'service_location_id');
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function taxCode()
    {
        return $this->belongsTo(TaxCode::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'recurring_invoice_services')
            ->withPivot('service_amount')
            ->withTimestamps();
    }
}
