<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ChatRequest;

class ChatRequestPolicy
{
    public function create(User $from, User $to): bool
    {
        // No puedes hablar contigo mismo
        if ($from->id === $to->id) {
            return false;
        }

        // Debes seguir al usuario
        if (! $from->following()
            ->where('followed_id', $to->id)
            ->exists()) {
            return false;
        }

        // No puede existir ya una solicitud pendiente
        if (ChatRequest::where('from_user_id', $from->id)
            ->where('to_user_id', $to->id)
            ->where('status', 'pending')
            ->exists()
        ) {
            return false;
        }

        // No puede existir ya una conversación
        if ($from->conversations()
            ->whereHas('users', fn($q) => $q->where('users.id', $to->id))
            ->exists()
        ) {
            return false;
        }

        return true;
    }
}
