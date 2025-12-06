<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('products')->get();
        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $order->load('products');
        return response()->json($order);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $total = 0;
        foreach ($data['products'] as $p) {
            $total += Product::find($p['id'])->price * $p['quantity'];
        }

        $order = Order::create([
            'user_id' => $data['user_id'],
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($data['products'] as $p) {
            $order->products()->attach($p['id'], [
                'quantity' => $p['quantity'],
                'price' => Product::find($p['id'])->price,
            ]);
        }

        return response()->json($order->load('products'), 201);
    }
}
