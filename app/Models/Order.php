<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'total_amount'
    ];
    protected $fillable = [
        'customer_name',
        'customer_email',
    ];

    public function getTotalAmountAttribute()
    {
        return 76;
    }
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
