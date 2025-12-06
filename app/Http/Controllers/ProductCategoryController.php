<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return response()->json(ProductCategory::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:product_categories,name',
            'slug' => 'required|string|unique:product_categories,slug',
            'description' => 'nullable|string',
        ]);

        $category = ProductCategory::create($data);
        return response()->json($category, 201);
    }

    public function show(ProductCategory $productCategory)
    {
        return response()->json($productCategory);
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|unique:product_categories,name,' . $productCategory->id,
            'slug' => 'sometimes|string|unique:product_categories,slug,' . $productCategory->id,
            'description' => 'nullable|string',
        ]);

        $productCategory->update($data);
        return response()->json($productCategory);
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
