<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocoe extends Model
{
    use HasFactory;

    protected $primaryKey = 'promocao_id';

    protected $fillable = [
        'produto_id',
        'tipo_desconto',
        'valor_desconto',
        'status',  
        'title_promo'
    ];

    public function promocoes () {
        return $this->belongsTo('App\Models\Product');
    }
}
