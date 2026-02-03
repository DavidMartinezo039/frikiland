<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\ChatRequest;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ProfileUser extends Component
{
    public User $user;
    public string $tab = 'posts';

    /* ===== CHAT UI STATES ===== */
    public bool $canRequestChat = false;
    public bool $chatRequested = false;
    public ?Conversation $conversation = null;

    protected $queryString = [
        'tab' => ['except' => 'posts'],
    ];

    public function mount(string $username): void
    {
        $this->user = User::where('username', $username)->firstOrFail();

        $viewer = Auth::user();

        if (! $viewer || $viewer->id === $this->user->id) {
            return;
        }

        /* ¿Sigo al usuario? */
        $isFollowing = $viewer->following()
            ->where('followed_id', $this->user->id)
            ->exists();

        if (! $isFollowing) {
            return;
        }

        /* ¿Ya existe conversación? */
        $this->conversation = Conversation::whereHas(
            'users',
            fn($q) => $q->where('users.id', $viewer->id)
        )->whereHas(
            'users',
            fn($q) => $q->where('users.id', $this->user->id)
        )->first();

        if ($this->conversation) {
            return;
        }

        /* ¿Solicitud pendiente? */
        $this->chatRequested = ChatRequest::where('from_user_id', $viewer->id)
            ->where('to_user_id', $this->user->id)
            ->where('status', 'pending')
            ->exists();

        $this->canRequestChat = ! $this->chatRequested;
    }

    public function setTab(string $tab): void
    {
        if (! in_array($tab, ['posts', 'favorites', 'shared'])) {
            return;
        }

        $this->tab = $tab;
    }

    public function getItemsProperty(): Collection
    {
        $viewer = Auth::user();

        return match ($this->tab) {
            'posts'     => $this->getPosts(),
            'favorites' => $this->getFavorites($viewer),
            'shared'    => $this->getShared($viewer),
            default     => collect(),
        };
    }

    protected function getPosts(): Collection
    {
        return $this->user->posts()
            ->withCount('comments')
            ->latest()
            ->get();
    }

    protected function getFavorites(?User $viewer): Collection
    {
        if (! $this->user->canViewFavorites($viewer)) {
            return collect();
        }

        return $this->user->favorites()
            ->with('favoritable.user')
            ->latest()
            ->get()
            ->map(fn($fav) => $fav->favoritable);
    }

    protected function getShared(?User $viewer): Collection
    {
        if (! $this->user->canViewShared($viewer)) {
            return collect();
        }

        return $this->user->shares()
            ->with('shareable.user')
            ->latest()
            ->get()
            ->pluck('shareable');
    }

    public function render()
    {
        return view('livewire.user.profile-user', [
            'items' => $this->items,
        ]);
    }
}
