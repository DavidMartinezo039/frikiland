<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\PostComment;

class NotificationsIndex extends Component
{
    public $notifications = [];

    public function mount()
    {
        if (! Auth::check()) return;

        $this->notifications = Auth::user()
            ->notifications()
            ->latest()
            ->get()
            ->map(fn($notification) => $this->mapNotification($notification))
            ->filter()
            ->values();

        Auth::user()->unreadNotifications->markAsRead();
    }

    private function mapNotification($notification)
    {
        $data = $notification->data;

        if ($data['type'] === 'user_followed') {
            $user = User::find($data['follower_id']);
            if (! $user) return null;

            return [
                'type' => 'user_followed',
                'user' => $user,
                'url'  => route('user.profile', $user->username),
                'read' => (bool) $notification->read_at,
                'time' => $notification->created_at->diffForHumans(),
            ];
        }

        if ($data['type'] === 'content_favorited') {
            $user = User::find($data['user_id']);
            if (! $user) return null;

            if ($data['model_type'] === Post::class) {
                return [
                    'type' => 'favorite_post',
                    'user' => $user,
                    'url'  => route('posts.show', $data['model_id']),
                    'read' => (bool) $notification->read_at,
                    'time' => $notification->created_at->diffForHumans(),
                ];
            }

            if ($data['model_type'] === PostComment::class) {
                $comment = PostComment::find($data['model_id']);
                if (! $comment || ! $comment->post) return null;

                return [
                    'type' => 'favorite_comment',
                    'user' => $user,
                    'url'  => route('posts.show', $comment->post->id) . '#comment-' . $comment->id,
                    'read' => (bool) $notification->read_at,
                    'time' => $notification->created_at->diffForHumans(),
                ];
            }
        }

        return null;
    }

    public function render()
    {
        return view('livewire.notifications.notifications-index');
    }
}
