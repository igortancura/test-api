<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Product\ProductFindAction;
use App\Exceptions\Api\ValidationApiException;
use App\Http\Requests\Api\Product\ProductStoreRequest;
use App\Http\Requests\Api\Product\ProductUpdateRequest;
use App\Http\Resources\Api\Message\ValidMessageResource;
use App\Http\Resources\Api\Product\ProductCollection;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Product;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(
        path: '/api/v1/products',
        description: 'index',
        summary: 'index products',
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProductCollection',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function index(): ProductCollection
    {
        return new ProductCollection(Product::paginate(config('app.api_paginate')));
    }

    #[OA\Post(
        path: '/api/v1/products',
        description: 'store',
        summary: 'store products',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/ProductStoreRequest',
            )
        ),
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProductResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function store(ProductStoreRequest $request): ProductResource
    {
        return new ProductResource(Product::create($request->validated()));
    }

    #[OA\Get(
        path: '/api/v1/products/{id}',
        description: 'show',
        summary: 'show product',
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProductResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function show(ProductFindAction $findAction, int $id): ProductResource
    {
        return new ProductResource($findAction->handle($id));
    }

    #[OA\Put(
        path: '/api/v1/products/{id}',
        description: 'update',
        summary: 'update product',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: '#/components/schemas/ProductStoreRequest',
            )
        ),
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ProductResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function update(ProductUpdateRequest $request, ProductFindAction $findAction, int $id): ProductResource
    {
        $product = $findAction->handle($id);
        $data = $request->validated();
        if (empty($data)) {
            throw ValidationApiException::withMessages([
                'message' => 'no data for updated',
            ]);
        }
        $product->update($data);
        return new ProductResource($product->refresh());
    }

    #[OA\Delete(
        path: '/api/v1/products/{id}',
        description: 'destroy',
        summary: 'destroy product',
        tags: ['Products'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/ValidMessageResource',
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Failure',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/InvalidMessageResource',
                )
            ),
        ]
    )]
    public function destroy(ProductFindAction $findAction, int $id): ValidMessageResource
    {
        ($findAction->handle($id))->delete();
        return new ValidMessageResource(
            [
                'messages' => ['Product deleted successfully'],
            ],
            200
        );
    }
}
