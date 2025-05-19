<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
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
