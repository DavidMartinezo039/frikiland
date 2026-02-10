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
        <a href="{{ route('shop-web') }}" class="cat {{ request()->routeIs('shop-web') ? 'active' : '' }}">
            TIENDA
        </a>

        @auth
            <a href="{{ route('shop-web.mine') }}" class="cat {{ request()->routeIs('shop-web.mine') ? 'active' : '' }}">
                MIS ARTÍCULOS
            </a>
        @else
            <a href="{{ route('login') }}" class="cat">
                MIS ARTÍCULOS
            </a>
        @endauth

        <a href="{{ route('shop-web.cart') }}"
            class="cat flex items-center gap-2 {{ request()->routeIs('shop-web.cart') ? 'active' : '' }}">
            <i class="bx bx-cart"></i>
            CARRITO
            <livewire:products.cart-counter />
        </a>
    </x-banner-categories>

    <div class="content-web">
        @if ($view === 'cart')
            <livewire:products.cart />
        @else
            <livewire:products.products :view="$view" />
        @endif
    </div>
</div>
