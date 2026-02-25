<div>
    <x-header>
        <x-slot:search>
            <div class="search">
                <input type="text" placeholder="Buscar…" aria-label="Buscar">
                <button>
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </x-slot:search>
    </x-header>

    <x-banner-categories>
        <a href="{{ route('shop-web') }}" class="cat">TIENDA</a>

        @auth
            
        @can('is-seller')
            
        <button x-on:click="$dispatch('filter-my-products')" class="cat">
            MIS ARTICULOS
        </button>
        @endcan

        <button wire:click="$dispatch('cart')" class="cat flex items-center gap-2">
            <i class="bx bx-cart"></i>
            CARRITO
            {{-- Llamamos al mini-componente --}}
            <livewire:products.cart-counter />
        </button>

        @endauth
    </x-banner-categories>

    <div class="content-web">
        <livewire:products.products />
    </div>
</div>