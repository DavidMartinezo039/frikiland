<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class SearchPosts extends Component
{
    public $q;

    public function mount()
    {
        $this->q = request('q');
    }

    public function render()
    {
        $posts = Post::where('content', 'like', '%' . $this->q . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.search-posts', compact('posts'));
    }
}
