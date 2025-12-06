<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProductCategory::all();

        Product::factory()->count(20)->create()->each(function ($product) use ($categories) {
            // Asignar categorías aleatorias
            $product->categories()->attach($categories->random(rand(1,2))->pluck('id')->toArray());
        });
    }
}
