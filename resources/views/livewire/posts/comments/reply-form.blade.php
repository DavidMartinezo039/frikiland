<div class="create-post-box relative">
    <div class="create-post-top">
        <img src="{{ asset(Auth::user()->avatar) }}" class="create-avatar">
        <textarea wire:model.defer="replyContent" class="create-textarea" placeholder="Escribe una respuesta…"></textarea>
    </div>

    @include('livewire.posts.media', [
        'media' => $replyMedia,
        'removable' => true,
        'removeMethod' => 'removeReplyMedia',
    ])

    <div class="create-actions">
        <div class="left-actions">
            <label for="replyMediaInput-{{ $comment->id }}">
                <i class="bx bx-image"></i>
            </label>
            <input type="file" id="replyMediaInput-{{ $comment->id }}" wire:model="newReplyMedia" multiple hidden>
        </div>

        <button wire:click="addReply" class="btn-post">
            Responder
        </button>
    </div>
</div>
