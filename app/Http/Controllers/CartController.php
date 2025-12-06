<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        $cart->load('products');
        return response()->json($cart);
    }

    public function addProduct(Request $request, Cart $cart)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->products()->syncWithoutDetaching([
            $data['product_id'] => ['quantity' => $data['quantity'], 'price_at_purchase' => Product::find($data['product_id'])->price]
        ]);

        return response()->json($cart->load('products'));
    }

    public function removeProduct(Cart $cart, Product $product)
    {
        $cart->products()->detach($product->id);
        return response()->json($cart->load('products'));
    }
}
