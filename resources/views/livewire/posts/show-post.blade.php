<div>
    <x-header>
        <x-slot:menu>
            <div class="menu">
                <a href="{{ route('social-web') }}">
                    <i class="bx bx-left-arrow-alt return"></i>
                </a>
            </div>
        </x-slot:menu>
    </x-header>

    <main class="wrap-main">
        <section class="main-content">
            {{-- POST --}}
            @include('livewire.posts.partials.post-item', ['post' => $post])

            {{-- COMENTARIOS --}}
            <livewire:posts.post-comments :post-id="$post->id" wire:key="post-comments-{{ $post->id }}" />
        </section>
    </main>
</div>
