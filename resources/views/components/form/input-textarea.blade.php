{{-- resources/views/components/ui/textarea.blade.php --}}
@props([
    'name',
    'label' => null,
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
        'xs' => 'text-xs px-2 py-1',
        'sm' => 'text-sm px-3 py-2',
        'lg' => 'text-lg px-4 py-3',
        'xl' => 'text-xl px-5 py-4',
        default => 'text-base px-4 py-2.5',
    };
    $baseClasses = [
        'block w-full rounded-md bg-white text-[color:var(--ui-body-color)] placeholder-gray-400',
        'border border-[color:var(--ui-border)]',
        "focus:outline-none focus:ring-2 focus:ring-[color:rgba(var(--ui-{$variant}-rgb),0.2)] focus:border-[color:rgb(var(--ui-{$variant}-rgb))]",
        $sizeClass,
    ];
@endphp

<div>
    @if($label)
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge(['class' => implode(' ', $baseClasses)]) }}
    >{{ old($name, $value) }}</textarea>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>