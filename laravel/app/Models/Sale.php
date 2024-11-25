<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_method',
        'freight',
        'discount',
        'coupon',
        'delivery_date',
        'notes',
    ];

    /**
     * Relacionamento com o cliente (Client).
     * Uma venda pertence a um único cliente.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com os itens de venda (SaleItem).
     * Uma venda pode ter vários itens.
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
