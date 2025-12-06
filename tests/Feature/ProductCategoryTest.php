<?php

use App\Models\ProductCategory;

beforeEach(function () {
    $this->category = ProductCategory::factory()->create();
});

test('a category can be created', function () {
    expect($this->category)->toBeInstanceOf(ProductCategory::class);
});

test('a category has name and slug', function () {
    expect($this->category->name)->not()->toBeEmpty()
        ->and($this->category->slug)->not()->toBeEmpty();
});
