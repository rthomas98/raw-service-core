<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditMemo extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'emails',
        'invoice_date',
        'user_id',
        'po_number',
        'message_displayed_on_credit_memo',
        'internal_memo',
        'attachments',
        'preferred_communication',
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
