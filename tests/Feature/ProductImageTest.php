<?php

use App\Models\Product;
use App\Models\ProductImage;

beforeEach(function () {
    $this->product = Product::factory()->create();
    $this->image = ProductImage::factory()->create(['product_id' => $this->product->id]);
});

test('a product can have images', function () {
    expect($this->image->product->id)->toBe($this->product->id);
});
