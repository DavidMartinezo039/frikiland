<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\PostComment;

class ContentReplied extends Notification
{
    use Queueable;

    public function __construct(
        public User $replier,
        public PostComment $comment
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'content_replied',
            'user_id' => $this->replier->id,
            'post_id' => $this->comment->post_id,
            'comment_id' => $this->comment->id,
            'excerpt' => str($this->comment->content)->limit(80),
        ];
    }
}
