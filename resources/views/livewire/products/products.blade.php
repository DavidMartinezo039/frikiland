<main class="wrap-main">
    {{-- Botón de volver automático si no estamos en el index --}}
    @if($view !== 'index')
        <button wire:click="backToIndex" class="mb-6 flex items-center text-blue-900 font-bold hover:underline">
            <i class="bx bx-left-arrow-alt text-2xl mr-1"></i> Volver al listado
        </button>
    @endif

    {{-- Switch de Vistas --}}
    @if($view === 'index')
        @include('livewire.products.partials.index')
    @elseif($view === 'show')
        @include('livewire.products.partials.show')
    @elseif(in_array($view, ['create', 'my-products', 'edit']))
        @auth
            @include('livewire.products.partials.' . $view)
        @else
            <div class="text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed">
                <i class="bx bx-lock-alt text-5xl text-gray-400"></i>
                <p class="mt-4 text-gray-600">Debes iniciar sesión para gestionar tus productos.</p>
                <a href="{{ route('login') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded">
                    Iniciar Sesión
                </a>
            </div>
        @endauth
    @elseif($view == 'cart')
        {{-- Aquí renderizamos el componente independiente del carrito --}}
        <livewire:products.cart />
    @endif
</main>
