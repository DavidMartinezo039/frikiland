<div>
    <x-header>
        <x-slot:search>
            <livewire:user-search-header />
        </x-slot:search>
    </x-header>

    <x-banner-categories>
        <a href="{{ route('social-web.for-you') }}"
            class="cat {{ request()->routeIs('social-web.for-you') ? 'active' : '' }}">
            PARA TI
        </a>

        <a class="cat active">
            Resultados "{{ $q }}"
        </a>
    </x-banner-categories>

    <main class="wrap-main">
        <section class="main-content">
            @forelse($posts as $post)
                @include('livewire.posts.partials.post-item', ['post' => $post])
            @empty
                <p style="text-align: center;">No hay posts que coincidan.</p>
            @endforelse
        </section>
    </main>
</div>
