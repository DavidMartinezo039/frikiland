<?php

namespace App\Notifications;

use App\Models\ChatRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChatRequestAccepted extends Notification
{
    use Queueable;

    public function __construct(
        public ChatRequest $chatRequest
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'chat_request_accepted',
            'from_user_id' => $this->chatRequest->to_user_id,
            'conversation_id' => $this->chatRequest->conversation_id,
            'chat_request_id' => $this->chatRequest->id,
        ];
    }
}
