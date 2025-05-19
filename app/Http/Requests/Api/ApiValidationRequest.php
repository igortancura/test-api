<?php

namespace App\Http\Requests\Api;

use App\Exceptions\Api\ValidationApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiValidationRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationApiException($validator);
    }
}
