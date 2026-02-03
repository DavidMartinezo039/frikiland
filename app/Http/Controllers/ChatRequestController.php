<?php

namespace App\Http\Controllers;

use App\Models\ChatRequest;
use App\Models\Conversation;
use App\Notifications\ChatRequestRejected;
use App\Notifications\ChatRequestAccepted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChatRequestController
{
    use AuthorizesRequests;

    /**
     * Aceptar solicitud de chat
     */
    public function accept(ChatRequest $chatRequest)
    {
        abort_unless($chatRequest->to_user_id === Auth::id(), 403);
        abort_unless($chatRequest->status === 'pending', 400);

        $conversation = Conversation::whereHas(
            'users',
            fn($q) => $q->where('users.id', $chatRequest->from_user_id)
        )->whereHas(
            'users',
            fn($q) => $q->where('users.id', $chatRequest->to_user_id)
        )->firstOrFail();

        if ($conversation->status !== 'pending') {
            return redirect()->route('chat.show', $conversation);
        }

        $conversation->update([
            'status' => 'active',
        ]);

        $chatRequest->update([
            'status' => 'accepted',
        ]);

        $chatRequest->fromUser->notify(
            new ChatRequestAccepted($chatRequest)
        );

        Auth::user()
            ->notifications()
            ->where('data->chat_request_id', $chatRequest->id)
            ->update(['read_at' => now()]);

        return redirect()->route('chat.show', $conversation);
    }

    /**
     * Rechazar solicitud de chat
     */
    public function reject(ChatRequest $chatRequest)
    {
        abort_unless($chatRequest->to_user_id === Auth::id(), 403);
        abort_unless($chatRequest->status === 'pending', 400);

        $conversation = Conversation::whereHas(
            'users',
            fn($q) => $q->where('users.id', $chatRequest->from_user_id)
        )->whereHas(
            'users',
            fn($q) => $q->where('users.id', $chatRequest->to_user_id)
        )->first();

        if ($conversation) {
            $conversation->delete();
        }

        $chatRequest->fromUser->notify(
            new ChatRequestRejected($chatRequest)
        );

        $chatRequest->delete();

        return redirect()->route('chat.index');
    }
}
