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
        abort_unless(
            $conversation->users->contains(Auth::id()),
            403
        );

        $this->conversation = $conversation;
        $this->messages = $chatService->getMessages($conversation);
    }

    public function send(ChatService $chatService)
    {
        if (trim($this->content) === '') {
            return;
        }

        if ($this->conversation->isRejected()) {
            return;
        }

        if ($this->conversation->isPending()) {

            if (! $this->isInitiator()) {
                return;
            }
        }

        $chatService->sendMessage(
            $this->conversation,
            Auth::user(),
            $this->content
        );

        $chatService->markAsRead($this->conversation, Auth::user());
        $this->messages = $chatService->getMessages($this->conversation);
        $this->content = '';
    }

    private function isInitiator(): bool
    {
        return $this->conversation
            ->messages()
            ->doesntExist()
            || $this->conversation
            ->users()
            ->wherePivot('user_id', Auth::id())
            ->exists();
    }

    public function render()
    {
        return view('livewire.chat.chat-window');
    }
}
