<?php

namespace App\Http\Resources\Api\Product;
use App\Http\Resources\Api\ApiResource;
use OpenApi\Attributes as OA;
#[OA\Schema(
    schema: 'ProductResource',
    properties: [
        new OA\Property(property: 'code', type: 'integer', example: 200),
        new OA\Property(
            property: 'data',
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'name', type: 'string'),
                new OA\Property(property: 'description', type: 'string'),
                new OA\Property(property: 'price', type: 'number'),
                new OA\Property(property: 'stock_quantity', type: 'integer'),
            ],
            type: 'object'
        ),
    ],
    type: 'object'
)]

class ProductResource extends ApiResource
{

}
