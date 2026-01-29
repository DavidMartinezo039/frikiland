<div class="notification-menu" x-data="{ open: false }">
    <button @click="open = !open" class="notification-btn">
        <div class="hola">
            <i class="bx bx-bell notification-icon"></i>

            @if ($unreadCount > 0)
                <span class="notification-badge">
                    {{ $unreadCount }}
                </span>
            @endif
        </div>
    </button>

    <div x-show="open" x-transition x-cloak @click.away="open = false" @keydown.escape.window="open = false"
        class="notification-dropdown">
        <p class="dropdown-title">Notificaciones</p>

        <ul class="notification-list">
            @forelse ($notifications as $notification)
                <li class="notification-item unread">
                    <a href="{{ $notification['url'] }}">
                        <strong>{{ $notification['user']->name }}</strong>

                        @if ($notification['type'] === 'user_followed')
                            te ha seguido
                        @elseif ($notification['type'] === 'favorite_post')
                            le ha gustado tu post
                        @elseif ($notification['type'] === 'favorite_comment')
                            le ha gustado tu comentario
                        @endif
                    </a>

                    <span class="time">{{ $notification['time'] }}</span>
                </li>
            @empty
                <li class="notification-item empty">
                    No tienes notificaciones nuevas
                </li>
            @endforelse
        </ul>

        <a href="{{ route('notifications.index') }}" wire:click="markAllAsRead" class="view-more">
            Ver más →
        </a>
    </div>
</div>
