{{-- resources/views/components/ui/textarea.blade.php --}}
@props([
    'name',
    'label' => null,
    'hint' => null,
    'value' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'rows' => 4,
    'required' => false,
    'placeholder' => null,
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'lg' => 'px-4 py-3 text-lg',
        'xl' => 'px-5 py-4 text-xl',
        default => 'px-3 py-1.5 text-base sm:text-sm/6',
    };
    $baseClasses = [
        'block w-full rounded-md bg-white text-[color:var(--ui-body-color)] placeholder-[color:var(--ui-muted)]',
        'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-transparent',
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

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($hint) aria-describedby="{{ $name }}-hint" @endif
        {{ $attributes->merge(['class' => implode(' ', $baseClasses)]) }}
    >{{ old($name, $value) }}</textarea>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>