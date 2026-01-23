<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class ProfileUser extends Component
{
    public User $user;
    public string $tab = 'posts';

    protected $queryString = [
        'tab' => ['except' => 'posts'],
    ];

    public function mount(string $username): void
    {
        $this->user = User::where('username', $username)->firstOrFail();
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
