<?php

namespace App\Notifications;

use App\Models\ChatRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChatRequestRejected extends Notification
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
            'type' => 'chat_request_rejected',
            'from_user_id' => $this->chatRequest->to_user_id, // quien rechaza
            'conversation_id' => optional(
                $this->chatRequest
                    ->fromUser
                    ->conversations()
                    ->whereHas(
                        'users',
                        fn($q) =>
                        $q->where('users.id', $this->chatRequest->to_user_id)
                    )
                    ->first()
            )->id,
            'message' => 'ha rechazado tu solicitud de conversación',
        ];
    }
}
