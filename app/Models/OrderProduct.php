<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
public $table = 'order_product';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'order_id',
        'product_id',
        'product_quantity'
    ];

    protected $hidden = [
        'order_id',
        'product_id',
    ];
}
