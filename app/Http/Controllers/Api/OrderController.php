<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\Order\OrderCreateAction;
use App\Actions\Api\Order\OrderFindAction;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Resources\Api\Order\OrderResource;
use OpenApi\Attributes as OA;


class OrderController extends Controller
{
    #[OA\Post(
        path: '/api/v1/orders',
        description: 'store',
        summary: 'store orders',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: '#/components/schemas/OrderStoreRequest',
            )
        ),
        tags: ['Orders'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/OrderResource',
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
    public function store(OrderStoreRequest $request, OrderCreateAction $action): OrderResource
    {
        return new OrderResource($action->handle($request));
    }

    #[OA\Get(
        path: '/api/v1/orders/{id}',
        description: 'show',
        summary: 'show order',
        tags: ['Orders'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Success',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/OrderResource',
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
    public function show(OrderFindAction $findAction, int $id): OrderResource
    {
        return new OrderResource($findAction->handle($id));
    }
}
