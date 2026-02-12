<table class="admin-table">
    <thead>
        <tr>
            <th class="col-user-p">User</th>
            <th class="col-content-p">Content</th>
            <th class="col-media-p">Media</th>
            <th class="col-comments-p">Comments</th>
            <th class="col-date-p">Date</th>
            <th class="col-actions-p">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>
                    <a href="{{ route('user.profile', $post->user->username) }}" class="admin-link">
                        <div class="wrap-user-admin">
                            <img src="{{ asset($post->user->avatar) }}" class="profile-avatar">
                            <div class="profile-user-admin">
                                {{ $post->user->name }}
                                <span>{{ '@' . $post->user->username }}</span>
                            </div>
                        </div>
                    </a>
                </td>

                <td>
                    <a href="{{ route('posts.show', $post) }}" class="admin-link">
                        {{ \Illuminate\Support\Str::limit($post->content, 75) }}
                    </a>
                </td>

                <td>
                    @if (!empty($post->media))
                        <span class="media-indicator" title="Media files">
                            <i class="bx bx-image"></i>
                            {{ count($post->media) }}
                        </span>
                    @else
                        <span class="no-media">—</span>
                    @endif
                </td>

                <td>
                    {{ $post->comments->count() }}
                </td>

                <td>
                    {{ $post->created_at->format('d/m/Y') }}
                </td>

                <td>
                    <button wire:click="edit({{ $post->id }})" class="admin-edit-btn">
                        Edit
                    </button>

                    <button wire:click="confirmDelete({{ $post->id }})" class="admin-delete-btn">
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
