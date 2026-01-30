<div>
    <x-header />

    <x-banner-categories class="banner-categories-chat">
        <a href="{{ route('chat.index') }}" class="cat active">
            <i class="bx bx-chat" style="font-size: 20px;"></i>
            CHATS
        </a>
    </x-banner-categories>

    <div class="chat-main">
        <div class="chat-complete">

            {{-- SIDEBAR --}}
            <livewire:chat.chat-sidebar />

            {{-- PANEL DERECHO --}}
            <div class="chat-window friends">
                <div class="title-friend-chat">
                    <p>Conectado - 1</p>
                </div>

                <div class="friend-connect"></div>
            </div>
        </div>
    </div>
</div>
