<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            $cart = Cart::create(['user_id' => $user->id]);

            // Agregar algunos productos al carrito
            $products = Product::inRandomOrder()->take(rand(1, 5))->get();
            foreach ($products as $p) {
                $cart->products()->attach($p->id, [
                    'quantity' => rand(1,3),
                    'price_at_purchase' => $p->price,
                ]);
            }
        });
    }
}
