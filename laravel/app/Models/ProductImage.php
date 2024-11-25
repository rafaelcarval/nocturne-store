<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'image_path',
    ];

    /**
     * Relacionamento com o produto (Product).
     * Uma imagem pertence a um único produto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
