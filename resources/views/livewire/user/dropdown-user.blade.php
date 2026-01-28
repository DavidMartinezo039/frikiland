<div class="user-menu" x-data="{ open: false }">
    <button class="user-avatar-btn" @click="open = !open" aria-haspopup="true" :aria-expanded="open.toString()">
        <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('images/default-avatar.png') }}"
            alt="User avatar">
    </button>

    <div x-show="open" x-transition x-cloak @click.away="open = false" @keydown.escape.window="open = false"
        class="user-dropdown" role="menu">
        <a href="{{ route('user.profile', auth()->user()->username) }}">Profile</a>
        <a href="{{ route('profile.edit') }}">Edit Profile</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                Sign out
            </button>
        </form>
    </div>
</div>
