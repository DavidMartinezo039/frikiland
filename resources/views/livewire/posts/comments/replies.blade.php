@if ($comment->replies()->count() > 0 && !isset($repliesToShow[$comment->id]))
    <button wire:click="loadMoreReplies({{ $comment->id }})" class="text-sm text-gray-500 mt-2 cursor-pointer">
        Mostrar respuestas
    </button>
@endif

@if (isset($repliesToShow[$comment->id]))
    @foreach ($comment->replies()->latest()->take($repliesToShow[$comment->id])->get() as $reply)
        @include('livewire.posts.comments.item', [
            'comment' => $reply,
        ])
    @endforeach

    <div class="mt-2 flex gap-3">
        @if ($repliesToShow[$comment->id] < $comment->replies()->count())
            <button wire:click="loadMoreReplies({{ $comment->id }})" class="text-sm text-gray-400 cursor-pointer">
                Mostrar más
            </button>
        @endif

        <button wire:click="loadLessReplies({{ $comment->id }})" class="text-sm text-gray-400 cursor-pointer">
            Mostrar menos
        </button>
    </div>
@endif
