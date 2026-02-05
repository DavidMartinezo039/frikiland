<div class="max-w-6xl mx-auto bg-gray-100 p-6 rounded-2xl shadow-sm border border-gray-200 animate-fade-in" wire:key="edit-product-{{ $selected_product->id }}">
    
    <div class="flex justify-between items-center mb-6">
        <span class="bg-amber-100 text-amber-800 text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest border border-amber-200">Panel de Edición</span>
    </div>

    <form wire:submit.prevent="updateProduct">
        <div class="flex flex-col md:flex-row gap-10 items-start">
            
            {{-- COLUMNA IZQUIERDA: GESTIÓN INTEGRAL DE IMÁGENES --}}
            <div class="w-full md:w-[380px] shrink-0 space-y-6">
                
                {{-- 1. FOTOS ACTUALES (BORRAR) --}}
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Fotos en la nube (Actuales)</label>
                    <div class="grid grid-cols-3 gap-2 p-3 bg-white rounded-xl border border-gray-200 shadow-inner min-h-[120px]">
                        @if($selected_product->images && count($selected_product->images) > 0)
                            @foreach($selected_product->images as $index => $img)
                                <div class="relative aspect-square rounded-lg overflow-hidden border group">
                                    <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/'.$img) }}" class="w-full h-full object-cover">
                                    {{-- Botón Borrar --}}
                                    <button type="button" 
                                            wire:click="removeOldImage({{ $index }})"
                                            class="absolute inset-0 bg-red-600/80 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xl">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-3 flex items-center justify-center text-gray-400 text-xs italic">Sin imágenes</div>
                        @endif
                    </div>
                </div>

                {{-- 2. FOTOS NUEVAS (PREVIEW) --}}
                <div>
                    <label class="block text-[10px] font-black text-blue-900 uppercase tracking-widest mb-2">Nuevas para subir</label>
                    <div class="grid grid-cols-3 gap-2 p-3 bg-blue-50/50 rounded-xl border-2 border-dashed border-blue-200 min-h-[100px]">
                        @foreach($images as $image)
                            @if(!is_string($image))
                                <div class="relative aspect-square rounded-lg overflow-hidden border-2 border-blue-500 shadow-sm">
                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                        @endforeach
                        
                        {{-- Botón añadir más --}}
                        <label class="relative aspect-square flex flex-col items-center justify-center bg-white rounded-lg border-2 border-dashed border-blue-300 hover:bg-blue-100 cursor-pointer transition">
                            <i class="bx bx-plus text-blue-600 text-2xl"></i>
                            <input type="file" wire:model="images" multiple class="hidden">
                        </label>
                    </div>
                    <div wire:loading wire:target="images" class="text-[10px] text-blue-600 font-bold mt-1 animate-pulse">Subiendo archivos temporales...</div>
                </div>

                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <p class="text-[10px] text-amber-700 leading-tight">
                        <i class="bx bx-info-circle"></i> Las fotos borradas en la zona blanca se eliminarán permanentemente al guardar cambios.
                    </p>
                </div>
            </div>

            {{-- COLUMNA DERECHA: DATOS (FLUÍDO) --}}
            <div class="flex-1 space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-blue-900 uppercase tracking-tighter mb-1">Nombre del producto</label>
                    <input type="text" wire:model="name" class="w-full text-2xl font-bold text-gray-900 uppercase bg-transparent border-b-2 border-gray-300 focus:border-blue-900 focus:ring-0 p-0 transition-colors">
                </div>

                <div class="flex gap-6">
                    <div class="flex-1">
                        <label class="block text-[10px] font-black text-blue-900 uppercase tracking-tighter mb-1">Precio (€)</label>
                        <input type="number" step="0.01" wire:model="price" class="w-full text-3xl font-bold text-blue-900 bg-transparent border-b-2 border-gray-300 focus:border-blue-900 focus:ring-0 p-0 transition-colors">
                    </div>
                    <div class="w-32">
                        <label class="block text-[10px] font-black text-blue-900 uppercase tracking-tighter mb-1">Stock Actual</label>
                        <input type="number" wire:model="stock" class="w-full text-3xl font-bold text-gray-600 bg-transparent border-b-2 border-gray-300 focus:border-blue-900 focus:ring-0 p-0 transition-colors">
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Sobre este producto</label>
                    <textarea wire:model="description" rows="5" class="w-full text-gray-600 text-sm leading-relaxed bg-transparent border-none focus:ring-0 p-0 resize-none"></textarea>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 md:flex-none px-12 py-4 bg-blue-900 text-white rounded-lg font-black hover:bg-blue-800 transition shadow-lg uppercase tracking-widest text-sm">
                        Confirmar y Guardar
                    </button>
                    <button type="button" wire:click="backToIndex" class="text-sm font-bold text-gray-400 hover:text-gray-600 uppercase">
                        Descartar
                    </button>
                </div>
                {{-- ESTADO DEL PRODUCTO (Activo/Desactivado) --}}
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <div>
                        <span class="block text-xs font-bold text-gray-700 uppercase">Visibilidad</span>
                        <span class="text-[10px] text-gray-500 font-medium">Define si el producto será visible para los clientes.</span>
                    </div>
                    
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="active" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-900"></div>
                        <span class="ml-3 text-xs font-black uppercase text-gray-700" x-text="$wire.active ? 'Activo' : 'Oculto'"></span>
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>