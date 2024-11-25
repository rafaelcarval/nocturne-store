<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relacionamento com produtos (Products).
     * Uma categoria pode ter muitos produtos.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
