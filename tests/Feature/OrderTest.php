<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->order = Order::factory()->create(['user_id' => $this->user->id]);
    $this->product = Product::factory()->create();
    $this->order->products()->attach($this->product->id, ['quantity' => 3, 'price' => $this->product->price]);
});

test('an order belongs to a user', function () {
    expect($this->order->user->id)->toBe($this->user->id);
});

test('an order can have products', function () {
    expect($this->order->products)->not()->toBeEmpty()
        ->and($this->order->products->first()->pivot->quantity)->toBe(3);
});
