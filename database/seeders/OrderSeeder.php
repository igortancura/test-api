<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()->count(10)->create();
        $products = Product::all();
        foreach (Order::all() as $order) {
            $steps = random_int(1, 5);
            for ($i = 0; $i < $steps; $i++) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $products->random()->id,
                    'product_quantity' => random_int(1, 3)
                ]);
            }
        }
    }
}
