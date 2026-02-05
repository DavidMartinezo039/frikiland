<div class="chat-window">
    @php
        $authUser = auth()->user();
        $otherUser = $conversation->users->firstWhere('id', '!=', $authUser->id);
        $chatRequest = $conversation->chatRequest;
    @endphp


    {{-- ================= CABECERA ================= --}}
    <div class="name-user-chat">
        <div class="img-user">
            <img src="{{ asset($otherUser->avatar) }}" width="40">
            <div class="circulo-verde"></div>
        </div>
        {{ $otherUser->name }}
    </div>

    {{-- ================= MENSAJES ================= --}}
    <div class="messages">
        @foreach ($messages as $message)
            <div class="message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                <p>{{ $message->content }}</p>
            </div>
        @endforeach
    </div>

    {{-- ================= ACEPTAR / RECHAZAR (solo receptor) ================= --}}
    @if ($conversation->isPending() && $chatRequest && auth()->id() === $chatRequest->to_user_id)
        <div class="chat-request-actions">
            <form method="POST" action="{{ route('chat-requests.accept', $chatRequest->id) }}">
                @csrf
                <button type="submit" class="btn-accept-window">
                    Aceptar
                </button>
            </form>

            <form method="POST" action="{{ route('chat-requests.reject', $chatRequest->id) }}">
                @csrf
                <button type="submit" class="btn-reject-window">
                    Rechazar
                </button>
            </form>
        </div>
    @endif

    {{-- ================= RECHAZADO ================= --}}
    @if ($conversation->isRejected())
        <div class="chat-blocked">
            Esta conversación ha sido rechazada.
        </div>
    @endif

    {{-- ================= ESPERANDO RESPUESTA (solo iniciador) ================= --}}
    @if ($conversation->isPending() && $chatRequest && auth()->id() === $chatRequest->from_user_id)
        <div class="chat-pending">
            Esperando respuesta del usuario…
        </div>
    @endif


    {{-- ================= INPUT (activo o iniciador pendiente) ================= --}}
    @if (
        $conversation->isActive() ||
            ($conversation->isPending() && $chatRequest && auth()->id() === $chatRequest->from_user_id))
        <div class="chat-input">
            <input type="text" wire:model.defer="content" wire:keydown.enter="send"
                placeholder="Escribe un mensaje…">

            <button wire:click="send">
                <i class="bx bx-send send"></i>
            </button>
        </div>
    @endif
</div>
