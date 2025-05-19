<?php

namespace App\Http\Requests\Api\Order;

use App\Http\Requests\Api\ApiValidationRequest;

class OrderStoreRequest extends ApiValidationRequest
{

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|string|email|max:255',
        ];
    }
}
