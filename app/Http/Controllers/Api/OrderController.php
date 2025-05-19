<?php

namespace App\Http\Controllers\Api;

use App\Actions\Api\OrderFindAction;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Http\Requests\Api\Order\OrderUpdateRequest;
use App\Http\Resources\Api\Order\OrderResource;
use App\Http\Resources\Api\Order\OrderCollection;
use App\Models\Order;
use App\Http\Resources\Api\Message\ValidMessageResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): OrderCollection
    {
        return new OrderCollection(Order::paginate(config('app.api_paginate')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): OrderResource
    {
        return new OrderResource(Order::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderFindAction $findAction, int $id): OrderResource
    {
        return new OrderResource($findAction->handle($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, OrderFindAction $findAction, int $id): OrderResource
    {
        $order = $findAction->handle($id);
        $order->update($request->validated());
        return new OrderResource($order->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderFindAction $findAction, int $id): ValidMessageResource
    {
        ($findAction->handle($id))->delete();
        return new ValidMessageResource(
            [
                'messages' => ['Order deleted successfully'],
            ],
            200
        );
    }
}
