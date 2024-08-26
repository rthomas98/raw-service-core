<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_code_name',
        'default_tax_code',
        'total_tax_rate',
    ];

    public function components()
    {
        return $this->hasMany(TaxCodeComponent::class);
    }

    public function calculateTotalTaxRate()
    {
        $this->total_tax_rate = $this->components->sum('rate');
        $this->save();
    }
}
