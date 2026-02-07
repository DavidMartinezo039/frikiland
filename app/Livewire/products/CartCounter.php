<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Cart;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CartCounter extends Component
{
    // Escucha los eventos para refrescarse automáticamente
    #[On('addToCart')]
    #[On('cartUpdated')]
    public function refreshCounter()
    {
        // Este método puede estar vacío, solo sirve para que Livewire 
        // detecte el evento y ejecute el render() de nuevo.
    }

    public function render()
    {
        $count = 0;

        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            // Usamos sum de la columna quantity en la tabla pivote
            $count = $cart ? $cart->products()->sum('quantity') : 0;
        }

        return view('livewire.products.cart-counter', [
            'count' => $count
        ]);
    }
}