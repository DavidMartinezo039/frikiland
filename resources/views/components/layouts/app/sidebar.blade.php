<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>FrikiLand</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col">
    <main class="flex-1">
        {{ $slot }}
    </main>

    <div class="mensajes">
        <div class="circulo-mansajes">
            @if (request()->routeIs('chat.*'))
                <a href="{{ route('social-web.for-you') }}" aria-label="Ir al inicio">
                    <i class="bx bxs-home"></i>
                </a>
            @else
                <a href="{{ route('chat.index') }}" aria-label="Ir a chats">
                    <i class="bx bx-chat"></i>
                </a>
            @endif
        </div>
    </div>

    <x-footer />
    @livewireScripts
</body>

</html>
