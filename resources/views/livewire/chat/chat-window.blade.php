<div class="chat-window">
    @php
        $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
    @endphp

    <div class="name-user-chat">
        <div class="img-user">
            <img src="{{ asset($otherUser->avatar) }}" width="40">
            <div class="circulo-verde"></div>
        </div>
        {{ $otherUser->name }}
    </div>

    <div class="messages">
        @foreach ($messages as $message)
            <div class="message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                <p>{{ $message->content }}</p>
            </div>
        @endforeach
    </div>

    <div class="chat-input">
        <input type="text" wire:model.defer="content" wire:keydown.enter="send" placeholder="Escribe un mensaje…">

        <button wire:click="send">
            <i class="bx bx-send send"></i>
        </button>
    </div>
</div>
