<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Post;

class ShowPost extends Component
{
    use WithFileUploads, AuthorizesRequests;

    public Post $post;

    /** Editar */
    public bool $editing = false;
    public string $editContent = '';
    public array $editMedia = [];
    public array $newEditMedia = [];

    /** Eliminar */
    public bool $confirmingDelete = false;

    public function mount(Post $post)
    {
        $this->post = $post->load('user')
            ->loadCount('comments');
    }

    /* -------- EDITAR -------- */

    public function edit()
    {
        $this->authorize('update', $this->post);

        $this->editing = true;
        $this->editContent = $this->post->content;
        $this->editMedia = $this->post->media ?? [];
    }

    public function updatePost()
    {
        $this->authorize('update', $this->post);

        $this->validate([
            'editContent' => 'required|min:1|max:280',
        ]);

        $mediaPaths = [];

        foreach ($this->editMedia as $item) {
            $mediaPaths[] = $item instanceof TemporaryUploadedFile
                ? $item->store('media', 'public')
                : $item;
        }

        $this->post->update([
            'content' => $this->editContent,
            'media' => $mediaPaths,
        ]);

        // refrescar modelo
        $this->post->refresh();

        $this->reset(['editing', 'editContent', 'editMedia', 'newEditMedia']);
    }

    public function cancelEdit()
    {
        $this->reset(['editing', 'editContent', 'editMedia', 'newEditMedia']);
    }

    /* -------- ELIMINAR -------- */

    public function confirmDelete()
    {
        $this->authorize('delete', $this->post);
        $this->confirmingDelete = true;
    }

    public function deletePost()
    {
        $this->authorize('delete', $this->post);

        $this->post->delete();

        redirect()->route('social-web');
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
    }

    public function render()
    {
        return view('livewire.posts.show-post', [
            'context' => 'show',
        ]);
    }
}
