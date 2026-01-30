<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;
use Illuminate\Support\Collection;

class ChatSidebar extends Component
{
    public Collection $conversations;

    public function mount(ChatService $chatService)
    {
        $this->conversations = $chatService
            ->chatListForUser(Auth::user());
    }

    public function render()
    {
        return view('livewire.chat.chat-sidebar');
    }
}
