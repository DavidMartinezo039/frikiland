<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatRequest;

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
        $this->requests = ChatRequest::with(['fromUser'])
            ->where('to_user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function accept($chatRequestId)
    {
        return redirect()->route('chat-requests.accept', $chatRequestId);
    }

    public function reject($chatRequestId)
    {
        return redirect()->route('chat-requests.reject', $chatRequestId);
    }

    public function render()
    {
        return view('livewire.chat.chat-pending-sidebar');
    }
}
