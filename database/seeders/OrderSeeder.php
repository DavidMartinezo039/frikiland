<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            if(rand(0,1)) {
                $products = Product::inRandomOrder()->take(rand(1,5))->get();
                $total = $products->sum(fn($p) => $p->price);

                $order = Order::create([
                    'user_id' => $user->id,
                    'total' => $total,
                    'status' => 'pending',
                ]);

                foreach ($products as $p) {
                    $order->products()->attach($p->id, [
                        'quantity' => rand(1,3),
                        'price' => $p->price,
                    ]);
                }
            }
        });
    }
}
