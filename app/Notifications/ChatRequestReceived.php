<?php

namespace App\Notifications;

use App\Models\ChatRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ChatRequestReceived extends Notification
{
    use Queueable;

    public function __construct(
        public ChatRequest $chatRequest
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'chat_request',
            'from_user_id' => $this->chatRequest->from_user_id,
            'chat_request_id' => $this->chatRequest->id,
            'conversation_id' => $this->chatRequest->conversation_id,
        ];
    }
}
