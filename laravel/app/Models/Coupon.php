<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_percentage',
        'quantity_allowed',
        'quantity_used',
    ];

    public function isValid()
    {
        return $this->quantity_used < $this->quantity_allowed;
    }
}
