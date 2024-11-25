<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'subtotal',
    ];

    /**
     * Relacionamento com a venda (Sale).
     * Um item pertence a uma única venda.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relacionamento com o produto (Product).
     * Um item está vinculado a um único produto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
