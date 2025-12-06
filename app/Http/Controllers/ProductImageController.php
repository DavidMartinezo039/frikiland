<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'path' => 'required|string',
            'is_main' => 'boolean',
        ]);

        $image = $product->images()->create($data);
        return response()->json($image, 201);
    }

    public function destroy(Product $product, ProductImage $image)
    {
        $image->delete();
        return response()->json(['message' => 'Image deleted']);
    }
}
