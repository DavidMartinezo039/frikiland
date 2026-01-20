<div class="wrap-profile">
    <a href="#" class="profile-link">
        <img src="{{ asset($item->user->avatar) }}" class="img-profile">

        <div class="profile-name">
            <p>{{ $item->user->name }}</p>
            <span>{{ '@' . $item->user->username }}</span>
        </div>
    </a>

    <div class="right-content">
        <span>{{ $item->created_at->diffForHumans() }}</span>
    </div>
</div>
