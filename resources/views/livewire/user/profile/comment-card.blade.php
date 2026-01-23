<article class="posts" wire:key="comment-{{ $context }}-{{ $comment->id }}">
    <div class="wrap-profile">
        <a href="{{ route('user.profile', $comment->user->username) }}" class="profile-link">
            <img src="{{ asset($comment->user->avatar) }}" class="img-profile">

            <div class="profile-name">
                <p>{{ $comment->user->name }}</p>
                <span>{{ '@' . $comment->user->username }}</span>
            </div>
        </a>

        <div class="right-content">
            <span>{{ $comment->created_at->diffForHumans() }}</span>
        </div>
    </div>

    <p class="text-main-content">{{ $comment->content }}</p>

    @if ($comment->media)
        <div class="content-img">
            @include('livewire.posts.media', [
                'media' => $comment->media,
                'removable' => false,
            ])
        </div>
    @endif

    <div class="content-icons">
        <div class="content-icons-left">
            <a href="{{ route('posts.show', $comment->post) }}#comment-{{ $comment->id }}" class="comment-link"
                title="Ver comentario en el post">
                <span>
                    <i class="bx bx-message-rounded"></i>
                    {{ $comment->replies()->count() }}
                </span>
            </a>

            <livewire:favorite-content :model="$comment"
                wire:key="fav-{{ $context }}-comment-{{ $comment->id }}" />

            <livewire:shared-content :model="$comment"
                wire:key="shared-{{ $context }}-comment-{{ $comment->id }}" />
        </div>
    </div>
</article>
