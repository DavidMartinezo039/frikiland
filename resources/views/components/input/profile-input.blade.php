@props([
    'label',
    'type' => 'text',
    'model',
    'required' => false,
    'placeholder' => null
])

<div class="input-box">
    <label for="{{ $model }}">{{ $label }}</label>

    <input
        id="{{ $model }}"
        name="{{ $model }}"
        type="{{ $type }}"
        wire:model="{{ $model }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
    >

    @error($model)
        <small class="error-text">{{ $message }}</small>
    @enderror
</div>
