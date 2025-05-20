<?php

namespace App\Actions\Api\Product;

use App\Exceptions\Api\ValidationApiException;
use App\Models\Product;

class ProductFindAction
{
    public function handle(int $id): Product
    {
        try {
            $product = Product::findOrFail($id);
        } catch (\Exception $exception) {
            throw ValidationApiException::withMessages([
                'message' => 'Product not found',
            ]);
        }
        return $product;
    }
}
