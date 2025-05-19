<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiValidationRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LoginRequest',
    required: [
        'email',
        'password'
    ],
    properties: [
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'password', type: 'string'),
    ],
    type: 'object'
)]
class LoginRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
}
