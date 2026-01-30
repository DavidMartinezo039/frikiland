<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatShow extends Component
{
    public Conversation $conversation;

    public function mount(Conversation $conversation)
    {
        abort_unless(
            $conversation->users->contains(Auth::id()),
            403
        );

        $this->conversation = $conversation;
    }

    public function render()
    {
        return view('livewire.chat.chat-show');
    }
}
