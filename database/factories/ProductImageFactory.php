<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'path' => $this->faker->image(storage_path('app/public/products'), 640, 480, null, false),
            'is_main' => $this->faker->boolean(50),
        ];
    }
}
