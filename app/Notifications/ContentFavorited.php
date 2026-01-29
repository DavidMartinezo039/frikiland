<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ContentFavorited extends Notification
{
    use Queueable;

    public function __construct(
        public User $user,
        public Model $model
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'content_favorited',
            'user_id' => $this->user->id,
            'model_type' => get_class($this->model),
            'model_id' => $this->model->id,
        ];
    }
}
