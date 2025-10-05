{{-- resources/views/components/ui/input.blade.php --}}
@props([
    'name',
    'label' => null,
    'value' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'type' => 'text',
    'required' => false,
    'placeholder' => null,
    'autocomplete' => null,
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'h-8 text-xs px-2',
        'sm' => 'h-9 text-sm px-3',
        'lg' => 'h-11 text-lg px-4',
        'xl' => 'h-12 text-xl px-5',
        default => 'h-10 text-base px-4',
    };
    $baseClasses = [
        'block w-full rounded-md bg-white text-[color:var(--ui-body-color)] placeholder-gray-400',
        'border border-[color:var(--ui-border)]',
        // Focus mit Variablenfarbe
        "focus:outline-none focus:ring-2 focus:ring-[color:rgba(var(--ui-{$variant}-rgb),0.2)] focus:border-[color:rgb(var(--ui-{$variant}-rgb))]",
        $sizeClass,
    ];
@endphp

<div>
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
        {{ $attributes->merge(['class' => implode(' ', $baseClasses)]) }}
    />

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>