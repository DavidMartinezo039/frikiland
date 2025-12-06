<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Figuras', 'Ropa', 'Juguetes', 'Comics', 'Posters'];

        foreach ($categories as $category) {
            ProductCategory::create([
                'name' => $category,
                'slug' => \Str::slug($category),
                'description' => "Categoría de {$category}",
            ]);
        }
    }
}
