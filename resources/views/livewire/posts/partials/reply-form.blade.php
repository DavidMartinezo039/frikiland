<article class="create-post-box relative mt-4" x-data="{ dragging: false }" x-on:dragover.prevent="dragging = true"
    x-on:dragleave.prevent="dragging = false"
    x-on:drop.prevent="
        dragging = false;
        $wire.uploadMultiple('{{ $newMediaModel }}', [...$event.dataTransfer.files])
    "
    :class="{ 'dragging': dragging }">

    <div class="create-post-top">
        <img src="{{ asset(Auth::user()->avatar) }}" class="create-avatar">

        <textarea wire:model.defer="{{ $contentModel }}" class="create-textarea" placeholder="Escribe una respuesta…">
        </textarea>
    </div>

    {{-- PREVIEW MEDIA --}}
    @include('livewire.posts.media', [
        'media' => $media,
        'removable' => true,
        'removeMethod' => str_contains($contentModel, 'reply') ? 'removeReplyMedia' : 'removeTempMedia',
    ])

    <div class="create-actions">
        <div class="left-actions">
            <label for="mediaInput-{{ $contentModel }}">
                <i class="bx bx-image"></i>
            </label>

            <input type="file" id="mediaInput-{{ $contentModel }}" wire:model="{{ $newMediaModel }}" multiple hidden>

            <i class="bx bx-smile"></i>
            <i class="bx bx-paperclip"></i>
        </div>

        <div>
            @isset($cancel)
                <button wire:click="{{ $cancel }}" class="btn-post">
                    Cancelar
                </button>
            @endisset

            <button wire:click="{{ $submit }}" class="btn-post">
                Responder
            </button>
        </div>
    </div>
</article>
