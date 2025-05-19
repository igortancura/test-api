<?php

namespace App\Http\Resources\Api\Product;

use App\Http\Resources\Api\ApiCollection;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductCollection',
    properties: [
        new OA\Property(property: 'code', type: 'integer', example: 200),
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ProductResource', type: 'object')
        ),
    ],
    type: 'object'
)]
class ProductCollection extends ApiCollection
{

}
