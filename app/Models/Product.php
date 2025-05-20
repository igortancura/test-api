<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'product_quantity',
    ];

    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity'
    ];
    protected $hidden = [
        'deleted_at',
        'pivot'
    ];

    public function getProductQuantityAttribute(): int|null
    {
        return empty($this->pivot) ? null : $this->pivot->product_quantity;
    }
}
