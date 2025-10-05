@props([
    'compact' => false,
    'align' => 'left', // left, center, right
])

@php
    $paddingClass = $compact ? 'p-1' : 'p-3';
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
@endphp

<td class="{{ $paddingClass }} {{ $alignClass }} text-body border-right-1 border-right-muted border-right-solid">
    {{ $slot }}
</td>
