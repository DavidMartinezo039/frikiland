<section class="main-content">
  
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