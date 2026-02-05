<div class="chat-name pending-sidebar">
    <div class="border-chat">
        <ul>
            <li>
                <i class="bx bx-message-square-add friend-icon"></i>
                Solicitudes
            </li>
        </ul>
    </div>

    <ul>
        @forelse ($requests as $request)
            <li class="chat-item pending-item">

                {{-- ENTRAR AL CHAT --}}
                <a href="{{ route('chat.show', $request->conversation_id) }}">
                    <div class="pending-content">
                        <div class="img-user">
                            <img src="{{ asset($request->fromUser->avatar) }}" width="40" height="40"
                                alt="{{ $request->fromUser->name }}">
                            <div class="circulo-verde"></div>
                        </div>

                        <div class="chat-info pending-text">
                            <strong>{{ $request->fromUser->name }}</strong>
                            <p class="last-message muted">
                                Quiere iniciar una conversación
                            </p>
                        </div>
                    </div>
                </a>

                {{-- ACCIONES --}}
                <div class="pending-actions">
                    <button type="button" wire:click.stop="accept({{ $request->id }})" class="btn-accept"
                        title="Aceptar conversación">
                        ✓
                    </button>

                    <button type="button" wire:click.stop="reject({{ $request->id }})" class="btn-reject"
                        title="Rechazar conversación">
                        ✕
                    </button>
                </div>

            </li>
        @empty
            <li class="empty-chat">
                No tienes solicitudes pendientes
            </li>
        @endforelse
    </ul>
</div>
