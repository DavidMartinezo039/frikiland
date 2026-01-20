<div>
    <x-header>
        <x-slot:menu>
            <div class="menu">
                <a href="{{ route('social-web') }}">
                    <i class="bx bx-left-arrow-alt return"></i>
                </a>
            </div>
        </x-slot:menu>
    </x-header>

    <main class="wrap-main">
        <section class="main-content">
            {{-- POST PRINCIPAL --}}
            <article class="posts" wire:key="post-{{ $post->id }}">

                <x-post-profile :item="$post" :show-actions="true" />

                <p class="text-main-content">
                    {{ $post->content }}
                </p>

                @if ($post->media)
                    <div class="content-img">
                        @include('livewire.posts.media', [
                            'media' => $post->media,
                            'removable' => false,
                        ])
                    </div>
                @endif

                {{-- ICONOS --}}
                <div class="content-icons">
                    <div class="content-icons-left">
                        <a href="{{ route('posts.show', $post) }}" class="comment-link">
                            <span>
                                <i class="bx bx-message-rounded"></i>
                                {{ $post->replies->count() }}
                            </span>
                        </a>

                        <livewire:posts.favorite-post :post="$post" :wire:key="'favorite-'.$post->id" />
                    </div>
                </div>
            </article>

            {{-- FORMULARIO ROOT --}}
            @auth
                @include('livewire.posts.partials.reply-form', [
                    'contentModel' => 'content',
                    'media' => $media,
                    'newMediaModel' => 'newMedia',
                    'submit' => 'addReply',
                ])
            @endauth

            {{-- REPLIES ROOT --}}
            @foreach ($replies as $reply)
                <article class="posts" wire:key="reply-{{ $reply->id }}">

                    <x-post-profile :item="$reply" :show-actions="false" />

                    <p class="text-main-content">
                        {{ $reply->content }}
                    </p>

                    @if ($reply->media)
                        <div class="content-img">
                            @include('livewire.posts.media', [
                                'media' => $reply->media,
                                'removable' => false,
                            ])
                        </div>
                    @endif

                    {{-- ICONOS --}}
                    <div class="content-icons">
                        <div class="content-icons-left">
                            <button wire:click="startReply({{ $reply->id }})">
                                <span>
                                    <i class="bx bx-message-rounded"></i>
                                    {{ $post->replies->count() }}
                                </span>
                            </button>

                            <livewire:posts.favorite-post :post="$post" :wire:key="'favorite-'.$post->id" />
                        </div>
                    </div>

                    {{-- FORMULARIO INLINE --}}
                    @if ($replyingTo === $reply->id)
                        <div class="ml-6">
                            @include('livewire.posts.partials.reply-form', [
                                'contentModel' => 'replyContent',
                                'media' => $replyMedia,
                                'newMediaModel' => 'newReplyMedia',
                                'submit' => 'addChildReply',
                                'cancel' => 'cancelReply',
                            ])
                        </div>
                    @endif

                    {{-- REPLIES HIJAS --}}
                    @php
                        $visible = $visibleReplies[$reply->id] ?? 0;
                        $totalChildren = $reply->replies()->count();
                        $children = $this->getVisibleReplies($reply);
                    @endphp


                    @foreach ($children as $child)
                        @php
                            $childVisible = $visibleReplies[$child->id] ?? 0;
                            $childTotal = $child->replies()->count();
                            $grandChildren = $this->getVisibleReplies($child);
                        @endphp

                        <article class="posts ml-6" wire:key="child-{{ $child->id }}">

                            <x-post-profile :item="$child" :show-actions="false" />

                            <p class="text-main-content">
                                {{ $child->content }}
                            </p>

                            {{-- ICONOS --}}
                            <div class="content-icons">
                                <div class="content-icons-left">
                                    <button wire:click="startReply({{ $child->id }})">
                                        <i class="bx bx-message-rounded"></i>
                                        Responder
                                    </button>
                                </div>
                            </div>

                            {{-- FORMULARIO INLINE --}}
                            @if ($replyingTo === $child->id)
                                <div class="ml-6">
                                    @include('livewire.posts.partials.reply-form', [
                                        'contentModel' => 'replyContent',
                                        'media' => $replyMedia,
                                        'newMediaModel' => 'newReplyMedia',
                                        'submit' => 'addChildReply',
                                        'cancel' => 'cancelReply',
                                    ])
                                </div>
                            @endif

                            {{-- NIETOS --}}
                            @foreach ($grandChildren as $grandChild)
                                <article class="posts ml-6" wire:key="child-{{ $grandChild->id }}">

                                    <x-post-profile :item="$grandChild" :show-actions="false" />

                                    <p class="text-main-content">
                                        {{ $grandChild->content }}
                                    </p>

                                </article>
                            @endforeach

                            {{-- MOSTRAR MÁS / MENOS (INFINITO) --}}
                            @if ($childTotal > 0)
                                <div class="ml-6 mt-2">
                                    @if ($childTotal > $childVisible)
                                        <button wire:click="showMoreReplies({{ $child->id }})"
                                            class="text-sm text-gray-500">
                                            Mostrar más
                                        </button>
                                    @elseif ($childVisible > 0)
                                        <button wire:click="showLessReplies({{ $child->id }})"
                                            class="text-sm text-gray-500">
                                            Mostrar menos
                                        </button>
                                    @endif
                                </div>
                            @endif

                        </article>
                    @endforeach

                    {{-- MOSTRAR MÁS / MENOS --}}
                    @if ($totalChildren > 0)
                        <div class="ml-6 mt-2">
                            @if ($totalChildren > $visible)
                                <button wire:click="showMoreReplies({{ $reply->id }})"
                                    class="text-sm text-gray-500">
                                    Mostrar más
                                </button>
                            @elseif ($visible > 0)
                                <button wire:click="showLessReplies({{ $reply->id }})"
                                    class="text-sm text-gray-500">
                                    Mostrar menos
                                </button>
                            @endif
                        </div>
                    @endif
                </article>
            @endforeach
        </section>
    </main>
</div>
