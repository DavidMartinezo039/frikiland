<div wire:key="cart-count-wrapper-{{ $count }}" class="inline-block">
    @if($count > 0)
        <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full animate-bounce">
            {{ $count }}
        </span>
    @endif
</div>