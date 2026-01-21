<?php

namespace App\Livewire\Posts;

use Livewire\Component;
use App\Models\Post;

class ShowPost extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post->load('user');
    }

    public function render()
    {
        return view('livewire.posts.show-post');
    }
}
