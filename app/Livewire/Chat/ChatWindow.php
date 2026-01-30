<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Services\ChatService;

class ChatWindow extends Component
{
    public Conversation $conversation;
    public $messages = [];
    public string $content = '';

    public function mount(Conversation $conversation, ChatService $chatService)
    {
        $this->conversation = $conversation;
        $this->messages = $chatService->getMessages($conversation);
    }

    public function send(ChatService $chatService)
    {
        if (trim($this->content) === '') return;

        $chatService->sendMessage(
            $this->conversation,
            Auth::user(),
            $this->content
        );

        $this->messages = $chatService->getMessages($this->conversation);
        $this->content = '';
    }

    public function render()
    {
        return view('livewire.chat.chat-window');
    }
}
