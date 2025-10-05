{{-- resources/views/components/ui/label.blade.php --}}
@props([
    'for' => null,
    'text' => null,
    'variant' => 'primary',
    'required' => false,
    'size' => 'md', // xs, sm, md, lg, xl
    'class' => '',
])

@php
    $sizeClass = match($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-md',
    };
@endphp

<label
    @if($for) for="{{ $for }}" @endif
    class="{{ $sizeClass }} font-medium mb-1 d-block text-{{ $variant }} {{ $class }}"
>
    {{ $text }}
    @if($required)
        <span class="text-danger">*</span>
    @endif
</label>