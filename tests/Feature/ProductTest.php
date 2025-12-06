<?php

use App\Models\Product;
use App\Models\ProductCategory;

beforeEach(function () {
    $this->category = ProductCategory::factory()->create();
    $this->product = Product::factory()->create();
    $this->product->categories()->attach($this->category->id);
});

test('a product can be created', function () {
    expect($this->product)->toBeInstanceOf(Product::class)
        ->and($this->product->categories->first()->id)->toBe($this->category->id);
});

test('a product has categories', function () {
    expect($this->product->categories)->not()->toBeEmpty();
});
