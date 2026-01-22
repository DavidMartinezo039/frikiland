<div class="content-icons">
    <div class="content-icons-left">
        <button wire:click="toggleReply({{ $comment->id }})">
            <span>
                <i class="bx bx-message-rounded"></i>
                {{ $comment->replies()->count() }}
            </span>
        </button>

        <livewire:favorite-content :model="$comment" :wire:key="'fav-comment-'.$comment->id" />

        <livewire:shared-content :model="$comment" :wire:key="'share-comment-'.$comment->id" />
    </div>
</div>
