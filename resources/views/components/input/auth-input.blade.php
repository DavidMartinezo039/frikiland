@props([
    'type' => 'text',
    'name',
    'placeholder' => '',
    'icon' => '',
    'value' => '',
    'required' => false,
    'autofocus' => false,
    'form' => null,
])

<div class="input-box">
    <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        @if ($autofocus) autofocus @endif>

    @if ($icon)
        <i class="bx {{ $icon }}"></i>
    @endif

    {{-- Error --}}
    @if ($form)
        @if (old('form') === $form)
            @error($name)
                <small class="error-text">{{ $message }}</small>
            @enderror
        @endif
    @else
        @error($name)
            <small class="error-text">{{ $message }}</small>
        @enderror
    @endif
</div>
