<div>
    <x-header>
        <x-slot:menu>
            <div class="menu">
                <a href="{{ route('social-web') }}">
                    <i class="bx bx-left-arrow-alt return"></i>
                </a>
            </div>
        </x-slot:menu>

        <x-slot:search>
            <livewire:user-search-header />
        </x-slot:search>
    </x-header>

    {{-- PERFIL --}}
    @include('livewire.user.profile.profile-header')

    {{-- CONTENIDO --}}
    <main class="wrap-main">
        <section class="main-content">
            @if ($items->isEmpty())
                @include('livewire.user.profile.profile-empty', ['tab' => $tab])
            @else
                @php
                    $context = $this->getName() . '-' . $tab;
                @endphp

                @foreach ($items as $item)
                    @if ($item instanceof \App\Models\Post)
                        @include('livewire.user.profile.post-card', [
                            'post' => $item,
                            'context' => $context,
                        ])
                    @elseif ($item instanceof \App\Models\PostComment)
                        @include('livewire.user.profile.comment-card', [
                            'comment' => $item,
                            'context' => $context,
                        ])
                    @endif
                @endforeach
            @endif
        </section>
    </main>
</div>
