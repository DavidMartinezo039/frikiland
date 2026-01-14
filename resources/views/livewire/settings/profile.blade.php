<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $bio = '';

    public $avatar; // archivo temporal
    public ?string $currentAvatar = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username ?? '';
        $this->bio = $user->bio ?? '';
        $this->currentAvatar = $user->avatar;
    }

    /**
     * Update the profile information.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:500'],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB
        ]);

        // Avatar upload
        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->currentAvatar = $user->avatar;
        $this->avatar = null;

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Resend verification email.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
};
?>

<section class="w-full">
    <x-header />

    <x-banner-categories class="banner-categories-top">
        <a class="cat active">EDIT PROFILE</a>
    </x-banner-categories>

    <div class="wrap-edit-profile">
        <x-settings.layout :heading="__('Profile')" :subheading="__('Update your public profile information')">
            <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
                {{-- Avatar --}}
                <div class="flex items-center gap-6">
                    <div>
                        <img src="{{ $avatar
                            ? $avatar->temporaryUrl()
                            : ($currentAvatar
                                ? asset('storage/' . $currentAvatar)
                                : asset('images/default-avatar.png')) }}"
                            class="h-20 w-20 rounded-full object-cover" alt="Avatar">
                    </div>

                    <div class="w-full">
                        <flux:input wire:model="avatar" type="file" accept="image/*" :label="__('Avatar')" />

                        @error('avatar')
                            <small class="text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Name --}}
                <flux:input wire:model="name" :label="__('Name')" type="text" required autocomplete="name" />

                {{-- Username --}}
                <flux:input wire:model="username" :label="__('Username')" type="text" required />

                {{-- Email --}}
                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required
                        autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <flux:text class="mt-2 text-sm">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="cursor-pointer text-sm"
                                wire:click.prevent="resendVerificationNotification">
                                {{ __('Re-send verification email') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !text-green-600">
                                {{ __('Verification link sent.') }}
                            </flux:text>
                        @endif
                    @endif
                </div>

                {{-- Bio --}}
                <div>
                    <flux:textarea wire:model="bio" :label="__('Bio')" rows="4"
                        placeholder="Tell something about yourself..." />

                    @error('bio')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4">
                    <flux:button variant="primary" type="submit" class="w-full">
                        {{ __('Save changes') }}
                    </flux:button>

                    <x-action-message on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>

            <livewire:settings.delete-user-form />
        </x-settings.layout>
    </div>

</section>
