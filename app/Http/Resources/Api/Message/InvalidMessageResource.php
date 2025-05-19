<?php

namespace App\Http\Resources\Api\Message;

use App\Http\Resources\Api\MessageResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'InvalidMessageResource',
    properties: [
        new OA\Property(property: 'code', type: 'integer', example: 400),
        new OA\Property(
            property: 'data',
            properties: [
                new OA\Property(property: 'messages', type: 'array', items: new OA\Items()),
            ],
            type: 'object'
        ),
    ],
    type: 'object'
)]
class InvalidMessageResource extends MessageResource
{

}
