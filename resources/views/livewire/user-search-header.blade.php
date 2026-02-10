<div class="search-wrapper">
    <div class="search">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar usuarios…" aria-label="Buscar">
        <button type="button">
            <i class="bx bx-search"></i>
        </button>
    </div>

    @if (strlen($search) >= 2)
        <div class="search-result">
            {{-- POSTS --}}
            <div class="search-section">
                <p class="search-title">Posts</p>

                <a href="{{ route('search.posts', ['q' => $search]) }}" class="search-post-link">
                    <i class="bx bx-search"></i>
                    {{ $search }}
                </a>
            </div>

            {{-- USUARIOS --}}
            @if ($users->count())
                <div class="search-section">
                    <p class="search-title">Usuarios</p>

                    @forelse($users as $user)
                        <a href="{{ route('user.profile', $user->username) }}" class="search-user">
                            <img src="{{ asset($user->avatar) }}">
                            <div class="name-search">
                                <p>{{ $user->name }}</p>
                                <span>{{ $user->username }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- VACÍO --}}
            @if (!$users->count())
                <div class="search-section">
                    <p class="search-title">Usuarios</p>

                    <div class="search-empty">
                        No hay usuarios llamdos “{{ $search }}”
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
