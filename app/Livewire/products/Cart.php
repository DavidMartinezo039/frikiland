<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Cart as CartModel;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    public function updateQuantity($productId, $newQty)
    {
        $cart = CartModel::where('user_id', Auth::id())->first();
        $product = Product::find($productId);

        if ($newQty > 0 && $newQty <= $product->stock) {
            // updateExistingPivot actualiza los campos en cart_items
            $cart->products()->updateExistingPivot($productId, [
                'quantity' => $newQty
            ]);
        } elseif ($newQty <= 0) {
            $this->removeItem($productId);
        }
    }

    public function removeItem($productId)
    {
        $cart = CartModel::where('user_id', Auth::id())->first();
        $cart->products()->detach($productId);
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        $cart = CartModel::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->products()->detach();
            $this->dispatch('cartUpdated');
        }
    }

    public function checkout()
{
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    $cart = \App\Models\Cart::where('user_id', auth()->id())->with('products')->first();
    
    $line_items = [];
    $totalAcumulado = 0;

    foreach ($cart->products as $product) {
        $subtotal = $product->pivot->price_at_purchase * $product->pivot->quantity;
        $totalAcumulado += $subtotal;

        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => ['name' => $product->name],
                'unit_amount' => (int)($product->pivot->price_at_purchase * 100),
            ],
            'quantity' => $product->pivot->quantity,
        ];
    }

    $session = \Stripe\Checkout\Session::create([
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => route('payment.success') . "?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url' => route('shop-web'),
    ]);

    // AQUÍ ESTÁ EL CAMBIO: Usamos 'total' (como tu migración)
    $order = \App\Models\Order::create([
        'user_id' => auth()->id(),
        'total' => $totalAcumulado, // Antes decía total_price, por eso fallaba
        'status' => 'unpaid',
    ]);

    // Opcional: Si quieres guardar ya los items en order_items (como en el video)
    foreach ($cart->products as $product) {
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $product->pivot->quantity,
            'price' => $product->pivot->price_at_purchase,
        ]);
    }

    return redirect()->away($session->url);
}
    public function render()
    {
        // Cargamos el carrito con sus productos y los datos de la tabla pivote
        $cart = CartModel::where('user_id', Auth::id())
            ->with('products')
            ->first();

        $items = $cart ? $cart->products : collect();
        
        // Calculamos el total usando los datos del pivote
        $total = $items->sum(function($product) {
            return $product->pivot->price_at_purchase * $product->pivot->quantity;
        });

        return view('livewire.products.cart', [
            'cartItems' => $items,
            'total' => $total
        ]);
    }
}