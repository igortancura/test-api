<?php

namespace App\Http\Resources\Api\Auth;

use App\Http\Resources\Api\MessageResource;
use App\Models\User;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TokenResource',
    properties: [
        new OA\Property(property: 'code', type: 'integer', example: 200),
        new OA\Property(
            property: 'data',
            properties: [new OA\Property(property: 'token', type: 'string')],
            type: 'object'
        ),
    ],
    type: 'object'
)]
class TokenResource extends MessageResource
{
    public function __construct(User $user)
    {
        parent::__construct([
            'token' => $user->createToken('token')->plainTextToken,
        ],
            201
        );
    }
}
