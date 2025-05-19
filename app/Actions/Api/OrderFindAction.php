<?php

namespace App\Actions\Api;

use App\Exceptions\Api\ValidationApiException;
use App\Models\Order;

class OrderFindAction
{
    public function handle(int $id): Order
    {
        try {
            $order = Order::findOrFail($id);
        } catch (\Exception $exception) {
            throw ValidationApiException::withMessages([
                'message' => 'Order not found',
            ]);
        }
        return $order;
    }
}
