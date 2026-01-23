<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ContentPrivacy extends Component
{
    /** VISIBILIDADES */
    public string $favoritesVisibility = 'public';
    public string $sharedVisibility = 'public';

    /** UI STATES */
    public bool $openFavorites = false;
    public bool $openShared = false;

    public bool $savedFavorites = false;
    public bool $savedShared = false;

    public function mount()
    {
        $user = Auth::user();

        $favorites = $user->contentPrivacies()
            ->where('type', 'favorites')
            ->first();

        $shared = $user->contentPrivacies()
            ->where('type', 'shared')
            ->first();

        $this->favoritesVisibility = $favorites->visibility ?? 'public';
        $this->sharedVisibility = $shared->visibility ?? 'public';
    }

    /* TOGGLES */
    public function toggleFavorites()
    {
        $this->openFavorites = ! $this->openFavorites;
        $this->savedFavorites = false;
    }

    public function toggleShared()
    {
        $this->openShared = ! $this->openShared;
        $this->savedShared = false;
    }

    /* SAVES */
    public function saveFavorites()
    {
        Auth::user()
            ->contentPrivacies()
            ->updateOrCreate(
                ['type' => 'favorites'],
                ['visibility' => $this->favoritesVisibility]
            );

        $this->savedFavorites = true;
        $this->openFavorites = false;
    }

    public function saveShared()
    {
        Auth::user()
            ->contentPrivacies()
            ->updateOrCreate(
                ['type' => 'shared'],
                ['visibility' => $this->sharedVisibility]
            );

        $this->savedShared = true;
        $this->openShared = false;
    }

    public function render()
    {
        return view('livewire.user.content-privacy');
    }
}
