<div class="max-w-6xl mx-auto bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200 animate-fade-in" 
     wire:key="show-product-{{ $selected_product->id }}">

    {{-- NIVEL 1: IMAGEN (IZQUIERDA) E INFO (DERECHA) --}}
    <div class="flex flex-col md:flex-row gap-10 items-start">
        
        {{-- CARRUSEL DE IMAGEN --}}
        {{-- El wire:key aquí es VITAL para que Alpine.js se reinicie con las nuevas fotos --}}
        <div class="w-full md:w-[380px] shrink-0" 
             wire:key="carousel-{{ $selected_product->id }}"
             x-data="{ 
                activeImage: 0, 
                images: {{ json_encode(array_map(fn($img) => str_starts_with($img, 'http') ? $img : asset('storage/'.$img), $selected_product->images ?? [])) }} 
             }">
            
            <div class="relative aspect-square bg-white rounded-xl border border-gray-200 overflow-hidden group">
                <template x-for="(img, index) in images" :key="index">
                    <img x-show="activeImage === index" 
                         :src="img" 
                         x-transition:enter="transition opacity-0 duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="absolute inset-0 w-full h-full object-contain p-4">
                </template>
                
                {{-- Flechas (Solo se ven si hay más de una imagen) --}}
                <template x-if="images.length > 1">
                    <div class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition">
                        <button @click="activeImage = (activeImage - 1 + images.length) % images.length" class="bg-white/90 p-1 rounded-full shadow-sm hover:bg-white"><i class="bx bx-chevron-left text-xl"></i></button>
                        <button @click="activeImage = (activeImage + 1) % images.length" class="bg-white/90 p-1 rounded-full shadow-sm hover:bg-white"><i class="bx bx-chevron-right text-xl"></i></button>
                    </div>
                </template>
            </div>

            {{-- Dots --}}
            <div class="flex justify-center gap-1.5 mt-3">
                <template x-for="(img, index) in images" :key="index">
                    <button @click="activeImage = index" 
                            :class="activeImage === index ? 'bg-blue-900 w-4' : 'bg-gray-300 w-1.5'" 
                            class="h-1.5 rounded-full transition-all"></button>
                </template>
            </div>
        </div>

        {{-- INFORMACIÓN A LA DERECHA --}}
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <h2 class="text-2xl font-bold text-gray-900 uppercase">{{ $selected_product->name }}</h2>
                @if($selected_product->sku)
                    <span class="text-xs font-mono bg-gray-200 px-2 py-1 rounded text-gray-500">SKU: {{ $selected_product->sku }}</span>
                @endif
            </div>

            <p class="text-3xl font-bold text-blue-900 mb-6 mt-2">
                {{ number_format($selected_product->price, 2, ',', '.') }} €
            </p>

            <div class="bg-gray-50 p-4 rounded-xl mb-6 border border-gray-200">
                <h4 class="font-bold text-gray-700 text-sm mb-2 uppercase tracking-wider">Descripción</h4>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $selected_product->description ?: 'No hay descripción disponible para este producto.' }}
                </p>
            </div>

            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-4 pt-6">
                    @if($selected_product->stock > 0)
                        <button 
                            wire:click.prevent="$dispatch('addToCart', { productId: {{ $selected_product->id }} })"
                            class="flex-1 md:flex-none px-12 py-4 bg-blue-900 text-white rounded-xl font-black uppercase tracking-widest hover:bg-blue-800 transition shadow-lg active:scale-95 flex items-center justify-center gap-3">
                            <i class="bx bx-cart-add text-2xl"></i>
                            Añadir al carrito
                        </button>
                    @else
                        <button disabled class="flex-1 md:flex-none px-12 py-4 bg-gray-300 text-white rounded-xl font-black uppercase tracking-widest cursor-not-allowed">
                            Sin Stock Disponible
                        </button>
                    @endif
                </div>
                
                <p class="text-xs text-gray-400">
                    <i class="bx bx-package"></i> Stock disponible: {{ $selected_product->stock }} unidades
                </p>
            </div>
        </div>
    </div>

    {{-- NIVEL 2: OPINIONES COLAPSABLES --}}
    <div x-data="{ open: false }" class="mt-12 border-t border-gray-200 pt-6">
        <button @click="open = !open" class="flex items-center justify-between w-full py-2 group">
            <span class="text-lg font-bold text-gray-800">Opiniones del producto</span>
            <i class="bx text-2xl transition-transform" :class="open ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
        </button>
        
        <div x-show="open" x-collapse x-cloak class="mt-4 grid gap-4">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <div class="flex justify-between mb-2">
                    <span class="font-bold text-sm">Usuario Demo</span>
                    <span class="text-xs text-gray-400">Hace 2 días</span>
                </div>
                <p class="text-sm text-gray-600 italic">"¡Excelente calidad! Superó mis expectativas."</p>
            </div>
        </div>
    </div>

    {{-- NIVEL 3: PRODUCTOS RELACIONADOS --}}
    <div class="mt-12 border-t border-gray-200 pt-8" 
         x-data="{ 
            scrollNext() { $refs.container.scrollBy({ left: 300, behavior: 'smooth' }) },
            scrollPrev() { $refs.container.scrollBy({ left: -300, behavior: 'smooth' }) }
         }">
        
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">También te puede interesar</h3>
            <div class="flex gap-2">
                <button @click="scrollPrev" class="p-2 border border-gray-200 rounded-full hover:bg-white shadow-sm transition"><i class="bx bx-chevron-left"></i></button>
                <button @click="scrollNext" class="p-2 border border-gray-200 rounded-full hover:bg-white shadow-sm transition"><i class="bx bx-chevron-right"></i></button>
            </div>
        </div>

        <div x-ref="container" class="flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-4">
            @foreach($products as $related)
                {{-- Evitamos mostrar el mismo producto en relacionados --}}
                @if($related->id !== $selected_product->id)
                    <div class="min-w-[200px] max-w-[200px] snap-start group cursor-pointer" 
                         wire:click="showProduct({{ $related->id }})"
                         wire:key="related-{{ $related->id }}">
                        
                        <div class="aspect-square bg-white rounded-lg overflow-hidden border border-gray-200 mb-2 relative">
                            @php
                                // Forzamos que sea un array si viene como string JSON
                                $relatedImages = is_string($related->images) ? json_decode($related->images, true) : $related->images;
                                $firstImage = $relatedImages[0] ?? 'no-image.png';
                            @endphp
                            <img src="{{ str_starts_with($firstImage, 'http') ? $firstImage : asset('storage/'.$firstImage) }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition"></div>
                        </div>
                        
                        <p class="text-sm font-bold truncate text-gray-800">{{ $related->name }}</p>
                        <p class="text-sm text-blue-900 font-bold">{{ number_format($related->price, 2, ',', '.') }} €</p>
                        
                        <button class="mt-2 block w-full py-1.5 text-center bg-white border border-gray-200 text-blue-600 text-xs font-bold rounded hover:bg-blue-900 hover:text-white hover:border-blue-900 transition duration-300">
                            Ver detalles
                        </button>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>