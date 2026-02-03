<?php

namespace App\Services;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

class ChatService
{
    /**
     * Lista de usuarios seguidos + conversación si existe
     */
    public function chatListForUser(User $user): Collection
    {
        return Conversation::where('status', 'active')
            ->whereHas('users', fn($q) => $q->where('users.id', $user->id))
            ->with(['users', 'lastMessage'])
            ->get()
            ->map(function ($conversation) use ($user) {
                return [
                    'conversation' => $conversation,
                    'user' => $conversation->users->firstWhere('id', '!=', $user->id),
                    'lastMessage' => $conversation->lastMessage,
                ];
            });
    }


    /**
     * Obtener o crear conversación privada (1 a 1)
     */
    public function getPrivateConversation(User $from, User $to): Conversation
    {
        $conversation = Conversation::whereHas(
            'users',
            fn($q) => $q->where('user_id', $from->id)
        )->whereHas(
            'users',
            fn($q) => $q->where('user_id', $to->id)
        )->first();

        if ($conversation) {
            return $conversation;
        }

        $conversation = Conversation::create();

        $conversation->users()->attach([
            $from->id,
            $to->id,
        ]);

        return $conversation;
    }

    /**
     * Enviar mensaje
     */
    public function sendMessage(
        Conversation $conversation,
        User $sender,
        string $content
    ): Message {
        return Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $sender->id,
            'content' => $content,
        ]);
    }

    /**
     * Obtener mensajes de una conversación
     */
    public function getMessages(Conversation $conversation): Collection
    {
        return $conversation->messages()
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();
    }

    public function markAsRead(Conversation $conversation, User $user): void
    {
        $conversation->messages()
            ->whereNull('read_at')
            ->where('user_id', '!=', $user->id)
            ->update([
                'read_at' => Carbon::now(),
            ]);
    }
}
