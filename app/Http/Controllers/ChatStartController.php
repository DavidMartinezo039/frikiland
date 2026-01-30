<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class ChatStartController
{
    public function __invoke(
        User $user,
        ChatService $chatService
    ) {
        $conversation = $chatService->getPrivateConversation(
            Auth::user(),
            $user
        );

        return redirect()->route('chat.show', $conversation);
    }
}
