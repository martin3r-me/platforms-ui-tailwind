{{-- resources/views/components/ui/input.blade.php --}}
@props([
    'name',
    'label' => null,
    'value' => null,
    'variant' => 'primary',   // primary, secondary, danger, ...
    'size' => 'md',           // xs, sm, md, lg, xl
    'errorKey' => null,
    'type' => 'text',
    'required' => false,
    'placeholder' => null,
    'autocomplete' => null,
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'input-xs',
        'sm' => 'input-sm',
        'lg' => 'input-lg',
        'xl' => 'input-xl',
        default => '',
    };
@endphp

<div class="form-group">
    @if($label)
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        {{ $attributes->merge([
            'class' => implode(' ', [
                'form-control',
                "border-{$variant}",
                "focus:border-{$variant}",
                $sizeClass,
            ]),
        ]) }}
    />

    @error($errorKey)
        <span class="form-error mt-1">{{ $message }}</span>
    @enderror
</div>