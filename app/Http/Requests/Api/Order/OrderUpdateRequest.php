<?php

namespace App\Http\Requests\Api\Order;

use App\Http\Requests\Api\ApiValidationRequest;

class OrderUpdateRequest extends ApiValidationRequest
{

    public function rules(): array
    {
        return [
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|string|email|max:255',
        ];
    }
}
