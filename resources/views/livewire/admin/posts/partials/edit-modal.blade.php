@if ($editingPostId)
    <div class="admin-modal-overlay">
        <div class="admin-modal">
            <h3>Edit Post</h3>

            <textarea wire:model="editingContent" class="admin-textarea" rows="5"></textarea>

            @if (!empty($editingMedia))
                <div class="admin-image-preview">
                    @foreach ($editingMedia as $index => $media)
                        <div class="admin-media-item">
                            <button wire:click="confirmRemoveMedia({{ $index }})" class="admin-remove-image-btn">
                                X
                            </button>

                            <img src="{{ Storage::url($media) }}" alt="Post media">
                        </div>
                    @endforeach
                </div>
            @endif

            @error('editingContent')
                <span class="admin-error">{{ $message }}</span>
            @enderror

            <div class="admin-modal-actions">
                <button wire:click="updatePost" class="admin-confirm-btn">
                    Save
                </button>

                <button wire:click="$set('editingPostId', null)" class="admin-cancel-btn">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endif

@if ($confirmingImageDelete)
    <div class="admin-modal-overlay">
        <div class="admin-modal">
            <p>Are you sure you want to remove this media?</p>

            <div class="admin-modal-actions">
                <button wire:click="removeMedia" class="admin-confirm-btn">
                    Yes, remove
                </button>

                <button wire:click="$set('confirmingImageDelete', false)" class="admin-cancel-btn">
                    Cancel
                </button>
            </div>
        </div>
    </div>
@endif
