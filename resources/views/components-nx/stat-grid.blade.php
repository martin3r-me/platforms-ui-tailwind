{{-- nx-stat-grid — responsives Raster für x-nx-stat. cols = Spalten ab lg (Default 4). --}}
@props(['cols' => 4])

@php
    $lg = match ((int) $cols) {
        2 => 'lg:grid-cols-2',
        3 => 'lg:grid-cols-3',
        5 => 'lg:grid-cols-5',
        default => 'lg:grid-cols-4',
    };
@endphp

<div {{ $attributes->class(['grid grid-cols-2 gap-3', $lg]) }}>
    {{ $slot }}
</div>
