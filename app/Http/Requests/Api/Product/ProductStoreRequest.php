<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiValidationRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductStoreRequest',
    required: [
        'name',
        'description',
        'price',
        'stock_quantity'
    ],
    properties: [
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'price', type: 'number'),
        new OA\Property(property: 'stock_quantity', type: 'integer'),
    ],
    type: 'object'
)]
class ProductStoreRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'price' => 'required|decimal:0,2|between:0,99999999.99',
            'stock_quantity' => 'required|integer',
        ];
    }
}
