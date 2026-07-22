@props([
    'compact' => false,
    'align' => 'left',
])

@php
    $pad = $compact ? 'px-2.5 py-1.5' : 'px-3 py-2.5';
    $al = match ($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
@endphp

<td {{ $attributes->class([$pad, $al, 'align-middle text-[color:var(--nx-text)]']) }}>
    {{ $slot }}
</td>
