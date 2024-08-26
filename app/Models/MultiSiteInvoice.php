<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiSiteInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'emails',
        'invoice_date',
        'user_id',
        'po_number',
        'start_date',
        'address_name',
        'address',
        'address_2',
        'city',
        'state_province',
        'zip_postal_code',
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
}
