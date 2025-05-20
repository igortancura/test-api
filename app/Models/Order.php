<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = [
        'total_amount',
    ];
    protected $fillable = [
        'customer_name',
        'customer_email',
    ];

    public function getTotalAmountAttribute(): string
    {
        $result = 0;
        foreach ($this->products as $product) {
            $result += $product->pivot->product_quantity * (int)($product->price * 100);
        }
        return number_format($result / 100, 2);
    }

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTrashed()->using(OrderProduct::class)->withPivot('product_quantity');
    }
}
