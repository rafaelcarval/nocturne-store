<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'sizes',
        'stock',
        'type',
        'category_id',
    ];

    /**
     * Relacionamento com a categoria (Category).
     * Um produto pertence a uma única categoria.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relacionamento com os itens de venda (SaleItem).
     * Um produto pode estar associado a vários itens de venda.
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relacionamento com ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Accessor para transformar 'sizes' em um array
    public function getSizesArrayAttribute()
    {
        return $this->sizes ? explode(',', $this->sizes) : [];
    }
}
