<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'total' => $this->faker->randomFloat(2, 20, 500), // total entre 20 y 500
            'status' => $this->faker->randomElement(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
        ];
    }
}
