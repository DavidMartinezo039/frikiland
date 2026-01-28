<div class="notification-menu" x-data="{ open: false }">
    <button @click="open = !open" class="notification-btn" aria-haspopup="true" :aria-expanded="open.toString()">
        <div class="hola">
            <i class="bx bx-bell notification-icon"></i>
            <span class="notification-badge">3</span>
        </div>
    </button>

    <div x-show="open" x-transition x-cloak @click.away="open = false" @keydown.escape.window="open = false"
        class="notification-dropdown" role="menu">
        <p class="dropdown-title">Notificaciones</p>

        <ul class="notification-list">
            <li class="notification-item">Usuario X comentó tu post</li>
            <li class="notification-item">Usuario Y te siguió</li>
            <li class="notification-item">Nueva respuesta a tu comentario</li>
        </ul>

        <a href="{{ route('notifications.index') }}" class="view-more">
            Ver más →
        </a>
    </div>
</div>
