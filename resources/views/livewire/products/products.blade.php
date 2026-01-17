<main class="wrap-main">
    @if($selected_product)
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-2xl shadow-sm border border-gray-100 animate-fade-in">
    
    {{-- BOTÓN VOLVER --}}
    <button wire:click="closeDetails" class="mb-6 flex items-center text-blue-900 font-bold hover:underline transition">
        <i class="bx bx-left-arrow-alt text-2xl mr-1"></i> Volver al catálogo
    </button>

    {{-- NIVEL 1: IMAGEN (IZQUIERDA) E INFO (DERECHA) --}}
    <div class="flex flex-col md:flex-row gap-10 items-start">
        
        {{-- CARRUSEL DE IMAGEN MÁS PEQUEÑA --}}
        <div class="w-full md:w-[380px] shrink-0" x-data="{ 
                activeImage: 0, 
                images: {{ json_encode(array_map(fn($img) => str_starts_with($img, 'http') ? $img : asset('storage/'.$img), $selected_product->images)) }} 
             }">
            <div class="relative aspect-square bg-gray-50 rounded-xl border border-gray-200 overflow-hidden group">
                <template x-for="(img, index) in images" :key="index">
                    <img x-show="activeImage === index" :src="img" 
                         class="absolute inset-0 w-full h-full object-contain p-4 transition-opacity duration-300">
                </template>
                
                {{-- Flechas --}}
                <div class="absolute inset-0 flex items-center justify-between px-2 opacity-0 group-hover:opacity-100 transition">
                    <button @click="activeImage = (activeImage - 1 + images.length) % images.length" class="bg-white/90 p-1 rounded-full shadow-sm"><i class="bx bx-chevron-left text-xl"></i></button>
                    <button @click="activeImage = (activeImage + 1) % images.length" class="bg-white/90 p-1 rounded-full shadow-sm"><i class="bx bx-chevron-right text-xl"></i></button>
                </div>
            </div>
            {{-- Dots --}}
            <div class="flex justify-center gap-1.5 mt-3">
                <template x-for="(img, index) in images" :key="index">
                    <button @click="activeImage = index" :class="activeImage === index ? 'bg-blue-900 w-4' : 'bg-gray-300 w-1.5'" class="h-1.5 rounded-full transition-all"></button>
                </template>
            </div>
        </div>

        {{-- INFORMACIÓN A LA DERECHA --}}
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900 uppercase">{{ $selected_product->name }}</h2>
            <p class="text-sm text-gray-400 mb-4">SKU: {{ $selected_product->sku }}</p>
            
            <div class="flex items-center gap-2 mb-4 text-yellow-400">
                <i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bxs-star"></i><i class="bx bx-star text-gray-300"></i>
                <span class="text-gray-500 text-sm">(12 opiniones)</span>
            </div>

            <p class="text-3xl font-bold text-blue-900 mb-6">${{ number_format($selected_product->price, 2) }}</p>

            <div class="bg-gray-50 p-4 rounded-xl mb-6">
                <h4 class="font-bold text-gray-700 text-sm mb-2">Sobre este producto</h4>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $selected_product->description }}</p>
            </div>

            <button class="w-full md:w-auto px-8 py-3 bg-blue-900 text-white rounded-lg font-bold hover:bg-blue-800 transition">
                Añadir al carrito
            </button>
        </div>
    </div>

    {{-- NIVEL 2: OPINIONES COLAPSABLES --}}
    <div x-data="{ open: false }" class="mt-12 border-t border-gray-100 pt-6">
        <button @click="open = !open" class="flex items-center justify-between w-full py-2 group">
            <span class="text-lg font-bold text-gray-800">Opiniones del producto</span>
            <i class="bx text-2xl transition-transform" :class="open ? 'bx-chevron-up rotate-180' : 'bx-chevron-down'"></i>
        </button>
        
        <div x-show="open" x-collapse x-cloak class="mt-4 grid gap-4">
            {{-- Ejemplo de opinión --}}
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                <div class="flex justify-between mb-2">
                    <span class="font-bold text-sm">Usuario Demo</span>
                    <span class="text-xs text-gray-400">Hace 2 días</span>
                </div>
                <p class="text-sm text-gray-600 italic">"¡Excelente calidad! Superó mis expectativas."</p>
            </div>
        </div>
    </div>

    {{-- NIVEL 3: CARRUSEL HORIZONTAL DE PRODUCTOS --}}
    <div class="mt-12 border-t border-gray-100 pt-8" x-data="{ 
            scroll: 0,
            scrollNext() { this.$refs.container.scrollBy({ left: 300, behavior: 'smooth' }) },
            scrollPrev() { this.$refs.container.scrollBy({ left: -300, behavior: 'smooth' }) }
         }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">También te puede interesar</h3>
            <div class="flex gap-2">
                <button @click="scrollPrev" class="p-2 border border-gray-200 rounded-full hover:bg-gray-50"><i class="bx bx-chevron-left"></i></button>
                <button @click="scrollNext" class="p-2 border border-gray-200 rounded-full hover:bg-gray-50"><i class="bx bx-chevron-right"></i></button>
            </div>
        </div>

        <div x-ref="container" class="flex gap-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory pb-4">
            @foreach($products as $related)
                <div class="min-w-[200px] max-w-[200px] snap-start group cursor-pointer" wire:click="showProduct({{ $related->id }})">
                    <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-100 mb-2">
                        <img src="{{ str_starts_with($related->images[0] ?? '', 'http') ? $related->images[0] : asset('storage/'.$related->images[0]) }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition">
                    </div>
                    <p class="text-sm font-bold truncate">{{ $related->name }}</p>
                    <p class="text-sm text-blue-900">${{ number_format($related->price, 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
    @else
    <section class="main-content">
        
        {{-- ==========================================================
             FORMULARIO DE CREACIÓN (Solo para usuarios autenticados)
             ========================================================== --}}
        @auth
            <article class="create-post-box" x-data="{ dragging: false }" 
                x-on:dragover.prevent="dragging = true"
                x-on:dragleave.prevent="dragging = false"
                x-on:drop.prevent="dragging = false; $wire.uploadMultiple($event.dataTransfer.files, 'images')"
                :class="{ 'dragging': dragging }">
                
                <div class="create-post-top" style="flex-direction: column; gap: 15px;">
                    <h2 style="font-weight: bold; font-size: 1.2rem; color: #333;">Nuevo Producto</h2>
                    
                    {{-- Nombre del Producto --}}
                    <input type="text" wire:model="name" class="create-textarea" 
                        placeholder="Nombre del producto..." style="height: 45px; border: 1px solid #e1e1e1; padding: 0 15px;">
                    
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        {{-- SKU --}}
                        <input type="text" wire:model="sku" placeholder="SKU (Opcional)" 
                            style="flex: 1; min-width: 150px; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                        
                        {{-- Precio --}}
                        <div style="position: relative; display: flex; align-items: center;">
                            <span style="position: absolute; left: 10px; color: #888;">$</span>
                            <input type="number" step="0.01" wire:model="price" placeholder="Precio" 
                                style="width: 110px; padding: 10px 10px 10px 25px; border-radius: 8px; border: 1px solid #ddd;">
                        </div>

                        {{-- Stock --}}
                        <input type="number" wire:model="stock" placeholder="Stock" 
                            style="width: 90px; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                    </div>

                    {{-- Descripción --}}
                    <textarea wire:model="description" class="create-textarea" 
                        placeholder="Describe las características del producto..." style="min-height: 80px;"></textarea>
                </div>

                <div class="create-actions">
                    <div class="left-actions">
                        {{-- Input de Imágenes --}}
                        <label for="imageInput" style="cursor: pointer; display: flex; align-items: center; gap: 5px; color: #555;">
                            <i class="bx bx-image-add" style="font-size: 1.6rem;"></i>
                            <span style="font-size: 0.9rem;">Añadir fotos</span>
                        </label>
                        <input type="file" id="imageInput" wire:model="images" multiple hidden>
                        
                        {{-- Switch de Activo --}}
                        <label style="margin-left: 20px; display: flex; align-items: center; gap: 8px; font-size: 0.9rem; cursor: pointer;">
                            <input type="checkbox" wire:model="active" style="width: 16px; height: 16px;"> 
                            Activo
                        </label>
                    </div>

                    <button wire:click="addProduct" class="btn-post" wire:loading.attr="disabled">
                        <span wire:loading.remove>Guardar Producto</span>
                        <span wire:loading>Subiendo...</span>
                    </button>
                </div>

                {{-- PREVIEW DE IMÁGENES ANTES DE SUBIR --}}
                @if ($images && count($images) > 0)
                    <div style="display: flex; gap: 8px; margin-top: 15px; flex-wrap: wrap; background: #f8f9fa; padding: 10px; border-radius: 8px;">
                        @foreach($images as $index => $img)
                            <div style="position: relative;">
                                <img src="{{ $img->temporaryUrl() }}" 
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 2px solid #fff; shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                        @endforeach
                    </div>
                @endif
            </article>
        @endauth

        {{-- ==========================================================
             LISTADO DE PRODUCTOS (Usa la variable $product)
             ========================================================== --}}
        {{-- CONTENEDOR EN GRID --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">
            @foreach ($products as $product)
                <article style="background: white; border-radius: 12px; border: 1px solid #eee; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.05);" 
                         onmouseover="this.style.transform='scale(1.02)'" 
                         onmouseout="this.style.transform='scale(1)'">
                    
                    {{-- Imagen Principal --}}
                    {{-- Dentro de tu @foreach ($products as $product) --}}
                    <div style="width: 100%; height: 150px; background: #f8f9fa; position: relative; overflow: hidden;">
                        @php
                            // Obtenemos la primera ruta del array. Si no existe, queda como null.
                            $firstImagePath = $product->images[0] ?? null;

                            // Construimos la URL: 
                            // 1. Si no hay imagen, usamos un placeholder.
                            // 2. Si la ruta empieza con http, es de Faker.
                            // 3. Si no, es una ruta local de storage.
                            if (!$firstImagePath) {
                                $src = 'https://via.placeholder.com/300x300?text=Sin+Imagen';
                            } else {
                                $src = str_starts_with($firstImagePath, 'http') 
                                    ? $firstImagePath 
                                    : asset('storage/' . $firstImagePath);
                            }
                        @endphp

                        <img src="{{ $src }}" 
                            alt="{{ $product->name }}" 
                            style="width: 100%; height: 100%; object-fit: cover;">
                        
                        {{-- Etiqueta de precio sobre la imagen --}}
                        <span style="position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,0.9); padding: 2px 8px; border-radius: 20px; font-weight: bold; font-size: 0.85rem; color: #27ae60; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            ${{ number_format($product->price, 2, ',', '.') }}
                        </span>
                    </div>

                    {{-- Info resumida --}}
                    <div style="padding: 12px; display: flex; flex-direction: column; gap: 5px; flex-grow: 1;">
                        <h4 style="margin: 0; font-size: 0.95rem; color: #333; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $product->name }}
                        </h4>
                    </div>

                    {{-- Botón para entrar --}}
                    <button wire:click="showProduct({{ $product->id }})" style="display: block; width: 100%; padding: 10px; text-align: center; background: #f0f2f5; color: #3498db; text-decoration: none; font-size: 0.85rem; font-weight: bold; border-top: 1px solid #eee;">
                        Ver detalles
                    </button>
                </article>
            @endforeach
        </div>

        {{-- LINKS DE PAGINACIÓN --}}
        <div style="margin-top: 30px;">
            {{ $products->links() }}
        </div>

        @if($products->isEmpty())
            <div style="text-align: center; padding: 50px; color: #999;">
                <p>No hay productos disponibles.</p>
            </div>
        @endif

    </section>
    @endif
</main>