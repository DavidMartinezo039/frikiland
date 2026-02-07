<div>
    <x-header>
        <x-slot:menu>
            <div class="menu" id="menu">
                <i class="bx bx-menu"></i>
            </div>
        </x-slot:menu>

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
        <a href="{{ route('shop-web') }}" class="cat">Tienda</a>
        <button x-on:click="$dispatch('filter-my-products')" class="cat">
            Mis artículos
        </button>
        <button wire:click="$dispatch('cart')" class="cat flex items-center gap-2">
            <i class="bx bx-cart"></i> 
            Carrito
            {{-- Llamamos al mini-componente --}}
            <livewire:products.cart-counter />
        </button>
    </x-banner-categories>


    <!-- POSTS -->
    <div class="content-web">
        <livewire:products.products />
    </div>
</div>
