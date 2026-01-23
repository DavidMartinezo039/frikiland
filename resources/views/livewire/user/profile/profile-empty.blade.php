<p class="no-posts">
    @if ($tab === 'favorites')
        Este usuario tiene los favoritos privados.
    @elseif ($tab === 'shared')
        Este usuario tiene los compartidos privados.
    @else
        No hay contenido para mostrar.
    @endif
</p>
