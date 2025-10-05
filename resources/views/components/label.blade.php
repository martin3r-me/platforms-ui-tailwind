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
    $sizeClass = match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-base',
    };
    $colorClass = "text-[color:var(--ui-{$variant})]";
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