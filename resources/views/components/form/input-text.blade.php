{{-- resources/views/components/ui/input.blade.php --}}
@props([
    'name',
    'label' => null,
    'hint' => null, // z.B. "Optional"
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
    // Größen an Tailwind-Pattern angelehnt (px-3 py-1.5 baseline)
    $sizeClass = match($size) {
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-lg',
        'xl' => 'px-5 py-2.5 text-xl',
        default => 'px-3 py-1.5 text-base sm:text-sm/6',
    };
    $baseClasses = [
        'block w-full rounded-md bg-white text-[color:var(--ui-body-color)] placeholder-[color:var(--ui-muted)]',
        'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-transparent',
        // Focus mit Variablenfarbe (analog Vorlage)
        "focus:outline-2 focus:-outline-offset-2 focus:outline-[color:rgb(var(--ui-{$variant}-rgb))]",
        $sizeClass,
    ];
@endphp

<div>
    @if($label)
        <div class="flex items-center justify-between">
            <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
            @if($hint)
                <span id="{{ $name }}-hint" class="text-sm/6 text-[color:var(--ui-muted)]">{{ $hint }}</span>
            @endif
        </div>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($hint) aria-describedby="{{ $name }}-hint" @endif
        {{ $attributes->merge(['class' => implode(' ', $baseClasses)]) }}
    />

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>