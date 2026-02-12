<table class="admin-table">
    <thead>
        <tr>
            <th class="col-user-c">User</th>
            <th class="col-comment-c">Comment</th>
            <th class="col-post-c">Post</th>
            <th class="col-replies-c">Replies</th>
            <th class="col-date-c">Date</th>
            <th class="col-actions-c">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($comments as $comment)
            <tr>
                <td>
                    <a href="{{ route('user.profile', $comment->user->username) }}" class="admin-link">
                        <div class="wrap-user-admin">
                            <img src="{{ asset($comment->user->avatar) }}" class="profile-avatar">
                            <div class="profile-user-admin">
                                {{ $comment->user->name }}
                                <span>{{ '@' . $comment->user->username }}</span>
                            </div>
                        </div>
                    </a>
                </td>

                <td style="max-width:300px;">
                    <a href="{{ route('posts.show', $comment->post) }}#comment-{{ $comment->id }}" class="admin-link">

                        {{ \Illuminate\Support\Str::limit($comment->content, 80) }}

                        @if ($comment->parent_id)
                            <div style="font-size:12px; color:#888;">
                                ↳ Reply
                            </div>
                        @endif

                    </a>
                </td>

                <td>
                    <a href="{{ route('posts.show', $comment->post) }}" target="_blank" style="color:#3b82f6;">
                        #{{ $comment->post->id }}
                    </a>
                </td>

                <td>
                    @if ($comment->replies->count())
                        <span class="media-indicator">
                            <i class="bx bx-reply"></i>
                            {{ $comment->replies->count() }}
                        </span>
                    @else
                        —
                    @endif
                </td>

                <td>
                    {{ $comment->created_at->format('d/m/Y') }}
                </td>

                <td>
                    <button wire:click="confirmDelete({{ $comment->id }})" class="admin-delete-btn">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
