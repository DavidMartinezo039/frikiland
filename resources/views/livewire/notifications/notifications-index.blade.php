<div class="notifications-page">
    <x-header />

    <x-banner-categories>
        <a class="cat active" href="{{ route('notifications.index') }}" wire:navigate>
            NOTIFICATIONS
        </a>
    </x-banner-categories>

    <div class="notifications-content">
        <ul class="notification-list-all">
            @forelse ($notifications as $notification)
                <li class="notification-item-all {{ $notification['read'] ? 'read' : 'unread' }}">

                    @if ($notification['type'] === 'chat_request')
                        <a href="{{ route('chat.show', $notification['conversation_id']) }}">
                            <div class="wrap-user-notification">
                                <img src="{{ asset($notification['user']->avatar) }}" class="img-notification-user">
                                <strong>{{ $notification['user']->name }}</strong>
                                quiere iniciar una conversación contigo
                            </div>
                        </a>
                    @elseif ($notification['type'] === 'chat_request_accepted')
                        <a href="{{ route('chat.show', $notification['conversation_id']) }}">
                            <div class="wrap-user-notification">
                                <img src="{{ asset($notification['user']->avatar) }}" class="img-notification-user">
                                <strong>{{ $notification['user']->name }}</strong>
                                ha aceptado tu solicitud de conversación
                            </div>
                        </a>
                    @elseif ($notification['type'] === 'chat_request_rejected')
                        <div class="wrap-user-notification">
                            <img src="{{ asset($notification['user']->avatar) }}" class="img-notification-user">
                            <strong>{{ $notification['user']->name }}</strong>
                            ha rechazado tu solicitud de conversación
                        </div>
                    @else
                        <a href="{{ $notification['url'] }}">
                            <div class="wrap-user-notification">
                                <img src="{{ asset($notification['user']->avatar) }}" class="img-notification-user">
                                <strong>{{ $notification['user']->name }}</strong>

                                @if ($notification['type'] === 'user_followed')
                                    te ha seguido
                                @elseif ($notification['type'] === 'favorite_post')
                                    le ha gustado tu post
                                @elseif ($notification['type'] === 'favorite_comment')
                                    le ha gustado tu comentario
                                @elseif ($notification['type'] === 'content_replied')
                                    te ha respondido:
                                    <span class="excerpt">“{{ $notification['excerpt'] }}”</span>
                                @endif
                            </div>
                        </a>
                    @endif

                    <span class="time">{{ $notification['time'] }}</span>
                </li>
            @empty
                <li class="notification-item-all empty">
                    No tienes notificaciones
                </li>
            @endforelse
        </ul>
    </div>
</div>
