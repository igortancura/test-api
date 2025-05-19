<?php

namespace App\Http\Resources\Api\Message;

use App\Http\Resources\Api\MessageResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ValidMessageResource',
    properties: [
        new OA\Property(property: 'code', type: 'integer', example: 200),
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
class ValidMessageResource extends MessageResource
{

}
