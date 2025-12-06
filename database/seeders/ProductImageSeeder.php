<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function ($product) {
            // Imagen principal
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'products/default.jpg',
                'is_main' => true,
            ]);

            // Imagenes extra
            for ($i=0; $i<rand(0,2); $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => 'products/' . 'placeholder_' . rand(1,100) . '.jpg',
                    'is_main' => false,
                ]);
            }
        });
    }
}
