<?php

namespace App\Actions\Api\Order;

use App\Exceptions\Api\ValidationApiException;
use App\Http\Requests\Api\Order\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderCreateAction
{
    public function handle(OrderStoreRequest $request): Order
    {
        $request = $request->validated();
        DB::beginTransaction();
        try {
            $order = Order::query()->create([
                'customer_name' => $request['customer_name'],
                'customer_email' => $request['customer_email'],
            ]);

            $products = Product::query()->whereIn('id', array_keys($request['products']))->get();
            if ($products->count() != count($request['products'])) {
                throw new \Exception();
            }

            foreach ($products as $product) {
                $newQuantity = $product->stock_quantity - $request['products'][$product->id];
                if ($newQuantity < 0) {
                    throw new \Exception();
                }
                $product->update(['stock_quantity' => $newQuantity]);
                OrderProduct::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_quantity' => $request['products'][$product->id],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            ValidationApiException::withMessages([
                'message' => 'Order not created',
            ]);
        }
        return $order;
    }
}
