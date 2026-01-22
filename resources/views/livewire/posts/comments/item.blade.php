<article class="posts" wire:key="comment-{{ $comment->id }}">

    {{-- HEADER --}}
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

    {{-- CONTENIDO --}}
    <p class="text-main-content">{{ $comment->content }}</p>

    @if ($comment->media)
        <div class="content-img">
            @include('livewire.posts.media', [
                'media' => $comment->media,
                'removable' => false,
            ])
        </div>
    @endif

    {{-- ACCIONES --}}
    @include('livewire.posts.comments.actions', [
        'comment' => $comment,
    ])

    {{-- FORM REPLY --}}
    @if ($replyingToId === $comment->id)
        @include('livewire.posts.comments.reply-form', [
            'comment' => $comment,
        ])
    @endif

    {{-- REPLIES --}}
    @include('livewire.posts.comments.replies', [
        'comment' => $comment,
    ])

</article>
