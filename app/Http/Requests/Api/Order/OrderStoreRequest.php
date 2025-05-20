<?php

namespace App\Http\Requests\Api\Order;

use App\Actions\Api\Product\ProductFindAction;
use App\Http\Requests\Api\ApiValidationRequest;
use Closure;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrderStoreRequest',
    required: [
        'customer_name',
        'customer_email',
        'products',
    ],
    properties: [
        new OA\Property(property: 'customer_name', type: 'string'),
        new OA\Property(property: 'customer_email', type: 'string'),
        new OA\Property(
            property: 'products', type: 'array', items: new OA\Items(
            example: '{"product_id": 27, "product_quantity":2}'
        )
        )
    ],
    type: 'object'
)]
class OrderStoreRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|string|email|max:255',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|min:1',
            'products.*.product_quantity' => 'required|integer|min:1',
            'products.*' => [
                'required',
                'array',
                function (string $attribute, mixed $value, Closure $fail) {
                    $product = (new ProductFindAction())->handle($value['product_id']);
                    if ($product->stock_quantity <= 0 || ($product->stock_quantity - $value['product_quantity']) < 0) {
                        $fail("The {$attribute} not enough stock.");
                    }
                }
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key = null, $default = null);
        $tmp = [];

        foreach ($validated['products'] as $product) {
            $tmp[$product['product_id']] = $product['product_quantity'];
        }

        $validated['products'] = $tmp;
        return $validated;
    }
}
