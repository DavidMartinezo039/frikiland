<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;

class ChatShow extends Component
{
    public Conversation $conversation;

    public function mount(Conversation $conversation, ChatService $chatService)
    {
        abort_unless(
            $conversation->users->contains(Auth::id()),
            403
        );

        $this->conversation = $conversation;

        if ($conversation->isActive()) {
            $chatService->markAsRead($conversation, Auth::user());
        }
    }


    public function render()
    {
        return view('livewire.chat.chat-show');
    }
}
