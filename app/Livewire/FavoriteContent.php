<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ContentFavorited;

class FavoriteContent extends Component
{
    public Model $model;
    public bool $isFavorite = false;

    public function mount(Model $model)
    {
        $this->model = $model;

        if (Auth::check()) {
            $this->isFavorite = $model->favorites()
                ->where('user_id', Auth::id())
                ->exists();
        }
    }

    public function toggle()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $favorite = $this->model
            ->favorites()
            ->where('user_id', $user->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $this->isFavorite = false;
            return;
        }

        $this->model->favorites()->create([
            'user_id' => $user->id,
        ]);

        $this->isFavorite = true;

        if ($this->model->user_id !== $user->id) {
            $this->model->user->notify(
                new ContentFavorited($user, $this->model)
            );
        }
    }

    public function render()
    {
        return view('livewire.favorite-content');
    }
}
