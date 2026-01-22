<div class="post-comments">

    {{-- CREAR COMENTARIO --}}
    @include('livewire.posts.comments.create')

    {{-- LISTADO --}}
    <div class="space-y-6">
        @forelse ($comments as $comment)
            @include('livewire.posts.comments.item', [
                'comment' => $comment,
            ])
        @empty
            <p class="text-gray-500">
                Sé el primero en comentar este post.
            </p>
        @endforelse
    </div>
</div>
