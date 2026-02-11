@props([
    'hasMore' => false,
    'loadMethod' => 'loadPosts',
    'offset' => 200,
])

<div x-data="{ loading: false }" x-init="window.addEventListener('scroll', () => {
    if (loading) return;
    if (!@entangle($attributes->wire('model') ?? 'hasMore')) return;

    if ((window.innerHeight + window.scrollY) >=
        document.body.offsetHeight - {{ $offset }}) {

        loading = true;

        $wire.{{ $loadMethod }}()
            .then(() => loading = false)
            .catch(() => loading = false);
    }
});">
    {{ $slot }}

    @if ($hasMore)
        <div class="text-center py-4 text-gray-500">
            Cargando más posts…
        </div>
    @endif
</div>
