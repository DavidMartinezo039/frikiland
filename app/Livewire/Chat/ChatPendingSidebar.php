<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatRequest;
use App\Notifications\ChatRequestAccepted;
use App\Notifications\ChatRequestRejected;

class ChatPendingSidebar extends Component
{
    public $requests = [];

    protected $listeners = [
        'chatRequestUpdated' => 'loadRequests',
    ];

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
    {
        $this->requests = ChatRequest::with(['fromUser', 'conversation'])
            ->where('to_user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function accept($chatRequestId)
    {
        $chatRequest = ChatRequest::where('id', $chatRequestId)
            ->where('to_user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $conversation = $chatRequest->conversation;

        $conversation->update([
            'status' => 'active',
        ]);

        $chatRequest->update([
            'status' => 'accepted',
        ]);

        $chatRequest->fromUser->notify(
            new ChatRequestAccepted($chatRequest)
        );

        $this->loadRequests();

        return redirect()->route('chat.show', $conversation->id);
    }

    public function reject($chatRequestId)
    {
        $chatRequest = ChatRequest::where('id', $chatRequestId)
            ->where('to_user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $conversation = $chatRequest->conversation;

        $chatRequest->fromUser->notify(
            new ChatRequestRejected($chatRequest)
        );

        $conversation->delete();
        $chatRequest->delete();

        $this->loadRequests();
    }

    public function render()
    {
        return view('livewire.chat.chat-pending-sidebar');
    }
}
