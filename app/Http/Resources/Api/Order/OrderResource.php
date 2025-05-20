<?php

namespace App\Http\Resources\Api\Order;

use App\Http\Resources\Api\ApiResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrderResource',
    properties: [
        new OA\Property(property: 'code', type: 'integer', example: 200),
        new OA\Property(
            property: 'data',
            properties: [
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'customer_name', type: 'string'),
                new OA\Property(property: 'customer_email', type: 'string'),
                new OA\Property(property: 'total_amount', type: 'string'),
                new OA\Property(
                    property: 'products', type: 'array', items: new OA\Items(
                    ref: '#/components/schemas/ProductResource', type: 'object'
                )
                )
            ],
            type: 'object'
        ),
    ],
    type: 'object'
)]
class OrderResource extends ApiResource
{

}
