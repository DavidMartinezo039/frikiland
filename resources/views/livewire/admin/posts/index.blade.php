<div>
    <x-header />

    <div class="admin-posts-container">
        <x-banner-categories>
            <a href="{{ route('manage') }}" class="cat {{ request()->routeIs('manage') ? 'active' : '' }}">
                ADMIN DASHBOARD
            </a>

            <a href="{{ route('admin.posts') }}" class="cat {{ request()->routeIs('admin.posts') ? 'active' : '' }}">
                MANAGE POSTS
            </a>
        </x-banner-categories>

        <div class="admin-search-wrapper">
            <input type="text" wire:model.live="search" placeholder="Search posts..." class="admin-search-input">
            <i class="bx bx-search"></i>
        </div>

        <div class="admin-table-wrapper">
            @include('livewire.admin.posts.partials.table')
        </div>

        <div class="admin-pagination">
            {{ $posts->links('livewire.pagination.pagination') }}
        </div>

        @include('livewire.admin.posts.partials.delete-modal')
        @include('livewire.admin.posts.partials.edit-modal')
    </div>
</div>
