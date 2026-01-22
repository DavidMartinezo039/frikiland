@auth
    <div class="mb-6">
        <article class="create-post-box relative" x-data="{ dragging: false }" x-on:dragover.prevent="dragging = true"
            x-on:dragleave.prevent="dragging = false"
            x-on:drop.prevent="
                    dragging = false;
                    $wire.uploadMultiple('newMedia', [...$event.dataTransfer.files])
                "
            :class="{ 'dragging': dragging }">

            <div class="create-post-top">
                <img src="{{ asset(Auth::user()->avatar) }}" class="create-avatar">
                <textarea wire:model.defer="content" class="create-textarea" placeholder="Escribe un comentario…"></textarea>
            </div>

            {{-- PREVIEW MEDIA --}}
            @include('livewire.posts.media', [
                'media' => $media,
                'removable' => true,
                'removeMethod' => 'removeMedia',
            ])

            <div class="create-actions">
                <div class="left-actions">
                    <label for="commentMediaInput">
                        <i class="bx bx-image"></i>
                    </label>
                    <input type="file" id="commentMediaInput" wire:model="newMedia" multiple hidden>
                </div>

                <button wire:click="addComment" class="btn-post">
                    Responder
                </button>
            </div>
        </article>
    </div>
@endauth
