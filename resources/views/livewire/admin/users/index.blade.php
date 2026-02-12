<div>
    <x-header />

    <div class="admin-posts-container">
        <x-banner-categories>
            <a href="{{ route('manage') }}" class="cat">
                ADMIN DASHBOARD
            </a>

            <a href="{{ route('admin.users') }}" class="cat active">
                MANAGE USERS
            </a>
        </x-banner-categories>

        <div class="admin-search-wrapper">
            <input type="text" wire:model.live="search" placeholder="Search users..." class="admin-search-input">
            <i class="bx bx-search"></i>
        </div>

        <div class="admin-table-wrapper">
            @include('livewire.admin.users.partials.table')
        </div>

        <div class="admin-pagination">
            {{ $users->links('livewire.pagination.pagination') }}
        </div>

        @include('livewire.admin.users.partials.delete-modal')
    </div>
</div>
