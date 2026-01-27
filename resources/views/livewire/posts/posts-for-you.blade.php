<div>
    @auth
        @include('livewire.posts.partials.create-post')
    @endauth

    <section x-data="{ loading: false }" x-init="window.addEventListener('scroll', () => {
        if (loading || !@entangle('hasMore')) return;

        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {
            loading = true;
            $wire.loadPosts().then(() => loading = false);
        }
    })">
        @foreach ($posts as $post)
            @include('livewire.posts.partials.post-item', ['post' => $post])
        @endforeach

        {{-- MODAL EDITAR --}}
        @if ($editingPost)
            @include('livewire.posts.modals.edit-post')
        @endif

        {{-- MODAL ELIMINAR --}}
        @if ($deletingPost)
            @include('livewire.posts.modals.delete-post')
        @endif

        @if ($hasMore)
            <div class="text-center py-4 text-gray-500">
                Cargando más posts…
            </div>
        @endif
    </section>
</div>
