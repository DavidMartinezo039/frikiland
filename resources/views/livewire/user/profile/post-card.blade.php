<article class="posts" wire:key="post-{{ $context }}-{{ $post->id }}">
    <div class="wrap-profile">
        <a href="{{ route('user.profile', $post->user->username) }}" class="profile-link">
            <img src="{{ asset($post->user->avatar) }}" class="img-profile">

            <div class="profile-name">
                <p>{{ $post->user->name }}</p>
                <span>{{ '@' . $post->user->username }}</span>
            </div>
        </a>

        <div class="right-content">
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>

    <p class="text-main-content">{{ $post->content }}</p>

    @if ($post->media)
        <div class="content-img">
            @include('livewire.posts.media', [
                'media' => $post->media,
                'removable' => false,
            ])
        </div>
    @endif

    <div class="content-icons">
        <div class="content-icons-left">
            <a href="{{ route('posts.show', $post) }}">
                <span>
                    <i class="bx bx-message-rounded"></i>
                    {{ $post->comments_count }}
                </span>
            </a>

            <livewire:favorite-content :model="$post"
                wire:key="fav-{{ $context }}-post-{{ $post->id }}" />

            <livewire:shared-content :model="$post"
                wire:key="shared-{{ $context }}-post-{{ $post->id }}" />
        </div>
    </div>
</article>
