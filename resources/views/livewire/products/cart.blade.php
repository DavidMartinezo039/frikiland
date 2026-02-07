<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mt-6">
    <div class="p-6 bg-blue-900 text-white flex justify-between items-center">
        <h2 class="text-xl font-black uppercase tracking-widest flex items-center gap-2">
            <i class="bx bx-shopping-bag"></i> Mi Carrito (DB)
        </h2>
        <span class="text-xs font-bold bg-blue-800 px-3 py-1 rounded-full uppercase">
            {{ $cartItems->sum('pivot.quantity') }} Artículos
        </span>
    </div>

    <div class="p-6">
        @if($cartItems->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($cartItems as $product)
                    <div class="py-4 flex items-center gap-4">
                        {{-- Miniatura --}}
                        <div class="w-20 h-20 bg-gray-50 rounded-lg border overflow-hidden shrink-0">
                            @php $firstImg = $product->images[0] ?? 'no-image.png'; @endphp
                            <img src="{{ str_starts_with($firstImg, 'http') ? $firstImg : asset('storage/'.$firstImg) }}" 
                                 class="w-full h-full object-cover">
                        </div>

                        {{-- Detalle --}}
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 uppercase text-sm">{{ $product->name }}</h3>
                            <p class="text-blue-900 font-black">{{ number_format($product->pivot->price_at_purchase, 2) }} €</p>
                        </div>

                        {{-- Selector de cantidad --}}
                        <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-3 py-1">
                            <button wire:click="updateQuantity({{ $product->id }}, {{ $product->pivot->quantity - 1 }})" class="hover:text-blue-900">
                                <i class="bx bx-minus"></i>
                            </button>
                            <span class="font-black text-sm w-4 text-center">{{ $product->pivot->quantity }}</span>
                            <button wire:click="updateQuantity({{ $product->id }}, {{ $product->pivot->quantity + 1 }})" class="hover:text-blue-900">
                                <i class="bx bx-plus"></i>
                            </button>
                        </div>

                        {{-- Subtotal y Borrar --}}
                        <div class="text-right min-w-[100px]">
                            <p class="font-black text-gray-900">
                                {{ number_format($product->pivot->price_at_purchase * $product->pivot->quantity, 2) }} €
                            </p>
                            <button wire:click="removeItem({{ $product->id }})" class="text-[10px] font-black text-red-500 uppercase hover:underline">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-end">
                <button wire:click="clearCart" class="text-xs font-bold text-gray-400 uppercase hover:text-red-600 transition">
                    Vaciar carrito
                </button>
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase">Total de la compra</p>
                    <p class="text-4xl font-black text-blue-900">{{ number_format($total, 2) }} €</p>
                    <button wire:click="checkout" wire:loading.attr="disabled" 
                        class="mt-4 w-full bg-blue-900 text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest hover:bg-blue-800 transition flex justify-center items-center">
                        <span wire:loading.remove>Pagar con Stripe</span>
                        <span wire:loading>Procesando...</span>
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-16">
                <i class="bx bx-cart-alt text-6xl text-gray-200 mb-4"></i>
                <p class="text-gray-400 font-bold uppercase italic">Tu carrito está vacío</p>
            </div>
        @endif
    </div>
</div>