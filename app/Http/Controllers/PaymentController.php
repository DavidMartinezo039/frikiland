<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function success()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('products')->first();

        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('shop-web');
        }

        // Usamos una transacción para que si algo falla, no se reste stock por error
        DB::transaction(function () use ($cart) {
            foreach ($cart->products as $product) {
                // 1. Restar el stock del producto
                $product->decrement('stock', $product->pivot->quantity);
                
                // Aquí podrías crear un registro en la tabla 'orders' si la tienes lista
            }

            // 2. Vaciar el carrito (borrar relaciones en la tabla pivote)
            $cart->products()->detach();
        });

        return redirect()->route('shop-web')->with('message', '¡Pago realizado con éxito! Tu pedido está en camino.');
    }

    public function webhook(Request $request)
{
    $payload = $request->getContent();
    $sig_header = $request->header('Stripe-Signature');
    $endpoint_secret = config('services.stripe.webhook_secret');

    try {
        $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }

    // Cuando el pago se completa correctamente [00:02:14]
    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;

        // Buscamos el pedido por el ID de sesión y lo marcamos como pagado [00:02:26]
        $order = \App\Models\Order::where('session_id', $session->id)
                                  ->where('status', 'unpaid')
                                  ->first();

        if ($order) {
            $order->update(['status' => 'paid']);
            // Aquí puedes enviar el email al usuario [00:02:37]
        }
    }

    return response()->json(['status' => 'success']);
}
}