@props([
    'striped' => false,
    'hover' => true,
    'compact' => false,
    'clickable' => false,
    'href' => null,
])

@php
    $classes = [
        'border-b border-[color:var(--nx-line)] last:border-0',
        'transition-colors hover:bg-[color:var(--nx-hover)]' => $hover,
        'even:bg-[color:var(--nx-bg)]' => $striped,
        'cursor-pointer' => $clickable,
    ];
@endphp

<tr {{ $attributes->class($classes) }}
    @if ($clickable && $href) onclick="window.location.href='{{ $href }}'" @endif>
    {{ $slot }}
</tr>
