@can('is-seller')
<div class="container mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mis productos</h1>

        <button wire:click="createProduct"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            + Crear producto
        </button>
    </div>

    @if($products->isEmpty())
        <div class="bg-gray-100 p-6 rounded text-center text-gray-600">
            Aún no has creado ningún producto.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                {{-- PASO 1: Añadir wire:key es OBLIGATORIO en Livewire para evitar errores de renderizado --}}
                <div class="border rounded shadow bg-white p-4" wire:key="product-{{ $product->id }}">
                    
                    <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $product->description }}</p>

                    <div class="mt-3 flex justify-between items-center">
                        <span class="font-bold">{{ number_format($product->price, 2, ',', '.') }} €</span>
                        <span class="text-sm {{ $product->active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>

                    <div class="mt-4 flex gap-2">
                        {{-- Editar --}}
                        <button wire:click="editProduct({{ $product->id }})"
                           class="flex-1 text-center bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded text-sm">
                            Editar
                        </button>

                        {{-- Eliminar --}}
                        <button 
                            wire:click="deleteProduct({{ $product->id }})"
                            wire:confirm="¿Estás seguro de que deseas eliminar este producto?"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">
                            Eliminar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{-- Asegúrate de que el componente use el trait WithPagination --}}
            {{ $products->links() }}
        </div>
    @endif
</div>
@endcan