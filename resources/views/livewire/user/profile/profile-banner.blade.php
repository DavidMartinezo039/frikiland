<div class="wrap-profile-cat cursor-pointer">
    <a wire:click.prevent="setTab('posts')" class="cat {{ $tab === 'posts' ? 'active' : '' }}">
        Posts
    </a>

    <a wire:click.prevent="setTab('shared')" class="cat {{ $tab === 'shared' ? 'active' : '' }}">
        Compartidos
    </a>

    <a wire:click.prevent="setTab('favorites')" class="cat {{ $tab === 'favorites' ? 'active' : '' }}">
        Favoritos
    </a>
</div>
