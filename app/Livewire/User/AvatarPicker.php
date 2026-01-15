<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\WithFileUploads;

class AvatarPicker extends Component
{
    use WithFileUploads;

    public User $user;

    public array $avatars = [];
    public ?string $selectedAvatar = null;

    public $uploadedAvatar; // archivo temporal

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->selectedAvatar = $this->user->avatar;

        $this->avatars = [
            'images/avatars/avatar1.jpg',
            'images/avatars/avatar2.jpg',
            'images/avatars/avatar3.jpg',
            'images/avatars/avatar4.jpg',
            'images/avatars/avatar5.jpg',
        ];
    }

    public function selectAvatar(string $avatar): void
    {
        $this->selectedAvatar = $avatar;
    }

    /**
     * Hook automático cuando cambia uploadedAvatar
     */
    public function updatedUploadedAvatar(): void
    {
        $this->validate([
            'uploadedAvatar' => ['image', 'max:2048'], // 2MB
        ]);

        $path = $this->uploadedAvatar->store('avatars', 'public');

        // Marcamos este avatar como seleccionado (sin guardar aún en users)
        $this->selectedAvatar = $path;
    }

    public function saveAvatar(): void
    {
        if ($this->selectedAvatar === $this->user->avatar) {
            return;
        }

        $this->user->avatar = $this->selectedAvatar;
        $this->user->save();

        session()->flash('success', 'Avatar actualizado correctamente.');
        $this->redirect(route('profile.edit'));
    }

    public function render()
    {
        return view('livewire.user.avatar-picker');
    }
}
