<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\Api\ApiValidationRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
  schema: 'RegisterRequest',
    required: [
        'email',
        'password',
         'name'
      ],
    properties: [
        new OA\Property(property: 'email', type: 'string'),
        new OA\Property(property: 'password', type: 'string'),
        new OA\Property(property: 'name', type: 'string')
    ],
    type: 'object'
)]
class RegisterRequest extends ApiValidationRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ];
    }
}
