@props([
    'compact' => false,
    'align' => 'left', // left, center, right
])

@php
    $paddingClass = $compact ? 'px-2 py-1.5' : 'p-3';
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
@endphp

<td class="{{ $paddingClass }} {{ $alignClass }} text-[color:var(--ui-body-color)]">
    {{ $slot }}
</td>
