<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCodeComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_code_id',
        'component_name',
        'agency_name',
        'rate',
    ];

    public function taxCode()
    {
        return $this->belongsTo(TaxCode::class);
    }

    protected static function booted()
    {
        static::saved(function ($component) {
            $component->taxCode->calculateTotalTaxRate();
        });

        static::deleted(function ($component) {
            $component->taxCode->calculateTotalTaxRate();
        });
    }
}
