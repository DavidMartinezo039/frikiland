<table class="admin-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Content</th>
            <th>Media</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>
                    <a href="{{ route('user.profile', $post->user->username) }}" class="admin-link">
                        {{ $post->user->name }}
                    </a>
                </td>

                <td>
                    <a href="{{ route('posts.show', $post) }}" class="admin-link">
                        {{ \Illuminate\Support\Str::limit($post->content, 80) }}
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
