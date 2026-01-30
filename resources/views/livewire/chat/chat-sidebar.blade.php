<div class="chat-name">
    <div class="border-chat">
        <ul>
            <li>
                <a href="#">
                    <i class="bx bx-group friend-icon"></i>
                    Amigos
                </a>
            </li>
        </ul>
    </div>

    <ul>
        @foreach ($conversations as $item)
            <li>
                <a href="{{ route('chat.start', $item['user']) }}">
                    <div class="img-user">
                        <img src="{{ asset($item['user']->avatar) }}" width="40" height="40"
                            alt="{{ $item['user']->name }}">
                        <div class="circulo-verde"></div>
                    </div>

                    <strong>{{ $item['user']->name }}</strong>
                </a>
            </li>
        @endforeach
    </ul>
</div>
