<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class SharedContent extends Component
{
    public $model;
    public bool $isShared = false;

    public function mount($model)
    {
        $this->model = $model;

        if (Auth::check()) {
            $this->isShared = $model->isSharedBy(Auth::user());
        }
    }

    public function toggleShare()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->model->shares()
            ->where('user_id', Auth::id())
            ->exists()
            ? $this->model->shares()->where('user_id', Auth::id())->delete()
            : $this->model->shares()->create(['user_id' => Auth::id()]);

        $this->isShared = ! $this->isShared;
    }

    public function render()
    {
        return view('livewire.shared-content');
    }
}
