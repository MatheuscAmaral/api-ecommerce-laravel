<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'produto_id';

    protected $fillable = [
        'image',
        'title',
        'price',
        'category',
        'flavor',
        'size',
        'stock',
        'status',
    ];

    public function promocoes () {
        return $this->belongsTo('App\Models\Promocoe');
    }
}
