<section class="w-full">
    <x-header />

    <x-banner-categories>
        <a class="cat" href="{{ route('profile.edit') }}" wire:navigate>
            {{ __('EDIT PROFILE') }}
        </a>

        <a class="cat" href="{{ route('user-password.edit') }}" wire:navigate>
            {{ __('PASSWORD') }}
        </a>

        <a class="cat active" href="{{ route('profile.configuration') }}" wire:navigate>
            {{ __('CONFIGURATION') }}
        </a>
    </x-banner-categories>

    <main class="main-content-privacy">
        <div class="content-privacy">
            <h2>~ Configuración de Privacidad ~</h2>

            {{-- FAVORITES --}}
            <div class="content-privacy-box mb-5">
                <button class="privacy-title" wire:click="toggleFavorites">
                    Publicaciones favoritas
                    <i class="bx {{ $openFavorites ? 'bx-chevron-up' : 'bx-chevron-down' }}"></i>
                </button>

                @if ($openFavorites)
                    <div class="privacy-options">
                        <label class="privacy-card {{ $favoritesVisibility === 'public' ? 'active' : '' }}">
                            <input type="radio" wire:model="favoritesVisibility" value="public">
                            🌍 Público
                        </label>

                        <label class="privacy-card {{ $favoritesVisibility === 'followers' ? 'active' : '' }}">
                            <input type="radio" wire:model="favoritesVisibility" value="followers">
                            👥 Solo seguidores
                        </label>

                        <label class="privacy-card {{ $favoritesVisibility === 'private' ? 'active' : '' }}">
                            <input type="radio" wire:model="favoritesVisibility" value="private">
                            🔒 Privado
                        </label>

                        <button class="btn-save-privacy" wire:click="saveFavorites">
                            Guardar
                        </button>
                    </div>
                @endif

                @if ($savedFavorites)
                    <small class="saved-msg">Configuración guardada</small>
                @endif
            </div>

            {{-- SHARED --}}
            <div class="content-privacy-box">
                <button class="privacy-title" wire:click="toggleShared">
                    Publicaciones compartidas
                    <i class="bx {{ $openShared ? 'bx-chevron-up' : 'bx-chevron-down' }}"></i>
                </button>

                @if ($openShared)
                    <div class="privacy-options">
                        <label class="privacy-card {{ $sharedVisibility === 'public' ? 'active' : '' }}">
                            <input type="radio" wire:model="sharedVisibility" value="public">
                            🌍 Público
                        </label>

                        <label class="privacy-card {{ $sharedVisibility === 'followers' ? 'active' : '' }}">
                            <input type="radio" wire:model="sharedVisibility" value="followers">
                            👥 Solo seguidores
                        </label>

                        <label class="privacy-card {{ $sharedVisibility === 'private' ? 'active' : '' }}">
                            <input type="radio" wire:model="sharedVisibility" value="private">
                            🔒 Privado
                        </label>

                        <button class="btn-save-privacy" wire:click="saveShared">
                            Guardar
                        </button>
                    </div>
                @endif

                @if ($savedShared)
                    <small class="saved-msg">Configuración guardada</small>
                @endif
            </div>
        </div>
    </main>
</section>
