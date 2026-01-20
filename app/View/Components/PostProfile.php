<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Post;

class PostProfile extends Component
{
    public Post $item;
    public bool $showActions;

    public function __construct(Post $item, bool $showActions = false)
    {
        $this->item = $item;
        $this->showActions = $showActions;
    }

    public function render()
    {
        return view('components.post-profile');
    }
}
