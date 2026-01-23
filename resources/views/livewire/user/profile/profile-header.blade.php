<div class="wrap-profile-all">
    <div class="wrapper-profile">
        <div>
            <div class="profile-users-blade">
                <img src="{{ asset($user->avatar) }}" class="profile-avatar" width="100px" height="100px">

                <div class="wrap-profile-content">
                    <p>{{ $user->name }}</p>

                    <div class="profile-users-sub">
                        <span>{{ '@' . $user->username }}</span>
                        <span>-</span>
                        <span>{{ $user->followers()->count() }} seguidores</span>
                        <span>-</span>
                        <span>{{ $user->posts()->count() }} posts</span>
                    </div>
                </div>

                @auth
                    @if (auth()->id() !== $user->id)
                        <div class="profile-follow">
                            <livewire:user.follow-user :user="$user" />
                        </div>
                    @endif
                @endauth
            </div>

            <div class="bio-profile-user">
                <p>{{ $user->bio }}</p>
            </div>
        </div>
        {{-- TABS --}}
        @include('livewire.user.profile.profile-banner')
    </div>
</div>
