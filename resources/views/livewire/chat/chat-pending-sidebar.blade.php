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

                <div class="pending-content">
                    <div class="img-user">
                        <img src="{{ asset($request->fromUser->avatar) }}" width="40" height="40"
                            alt="{{ $request->fromUser->name }}">

                        <div class="circulo-verde"></div>
                    </div>

                    <div class="chat-info">
                        <strong>{{ $request->fromUser->name }}</strong>
                        <p class="last-message muted">
                            Quiere iniciar una conversación
                        </p>
                    </div>
                </div>

                <div class="pending-actions">
                    <button wire:click="accept({{ $request->id }})" class="btn-accept" title="Aceptar conversación">
                        ✓
                    </button>

                    <button wire:click="reject({{ $request->id }})" class="btn-reject" title="Rechazar conversación">
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
