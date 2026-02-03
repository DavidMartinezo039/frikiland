@php
    use Illuminate\Support\Str;
@endphp

<div class="chat-name">
    <div class="border-chat">
        <ul>
            <li>
                <i class="bx bx-group friend-icon"></i>
                Conversaciones
            </li>
        </ul>
    </div>

    <ul>
        @forelse ($conversations as $item)
            <li class="chat-item">
                <a href="{{ route('chat.show', $item['conversation']) }}">

                    <div class="img-user">
                        <img src="{{ asset($item['user']->avatar) }}" width="40" height="40"
                            alt="{{ $item['user']->name }}">

                        <div class="circulo-verde"></div>

                        @if ($item['lastMessage'] && $item['lastMessage']->read_at === null && $item['lastMessage']->user_id !== auth()->id())
                            <span class="unread-dot"></span>
                        @endif
                    </div>

                    <div class="chat-info">
                        <strong>{{ $item['user']->name }}</strong>

                        @if ($item['lastMessage'])
                            <p class="last-message">
                                {{ Str::limit($item['lastMessage']->content, 35) }}
                            </p>
                        @else
                            <p class="last-message muted">
                                Conversación iniciada
                            </p>
                        @endif
                    </div>

                </a>
            </li>
        @empty
            <li class="empty-chat">
                No tienes conversaciones aún
            </li>
        @endforelse
    </ul>
</div>
