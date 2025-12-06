<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->cart = Cart::factory()->create(['user_id' => $this->user->id]);
    $this->product = Product::factory()->create();
    $this->cart->products()->attach($this->product->id, ['quantity' => 2, 'price_at_purchase' => $this->product->price]);
});

test('a cart belongs to a user', function () {
    expect($this->cart->user->id)->toBe($this->user->id);
});

test('a cart can have products', function () {
    expect($this->cart->products)->not()->toBeEmpty()
        ->and($this->cart->products->first()->pivot->quantity)->toBe(2);
});
