{{-- resources/views/components/ui/label.blade.php --}}
@props([
    'for' => null,
    'text' => null,
    'variant' => 'primary',
    'required' => false,
    'size' => 'md',
    'class' => '',
])

@php
    // Vereinheitlichung mit Formularvorlagen: text-sm/6 als Standard
    $sizeClass = match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm/6',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-sm/6',
    };
    $colorClass = "text-[color:var(--ui-secondary)]";
@endphp

<label
    @if($for) for="{{ $for }}" @endif
    class="{{ $sizeClass }} font-medium mb-1 block {{ $colorClass }} {{ $class }}"
>
    {{ $text }}
    @if($required)
        <span class="text-[color:var(--ui-danger)]">*</span>
    @endif
</label>