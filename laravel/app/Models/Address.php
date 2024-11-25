<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'state', 'is_default'
    ];

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
