<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Relacionamento com as vendas (Sales).
     * Um cliente pode ter muitas vendas.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
