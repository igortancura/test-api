<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class MessageResource extends JsonResource
{
    private int $statusCode;

    public function __construct($resource, int $statusCode = 200)
    {
        $this->statusCode = $statusCode;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->setStatusCode($this->statusCode);
    }

    public function with(Request $request): array
    {
        return ['code' => $this->statusCode];
    }
}
