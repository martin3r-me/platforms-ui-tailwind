{{--
    nx-card — Notion-Grundfläche (surface + Hairline, kein Schatten).

    <x-nx-card>…</x-nx-card>            Standard, mit Padding
    <x-nx-card flush>…</x-nx-card>       ohne Padding
    <x-nx-card hover>…</x-nx-card>       dezente Hover-Fläche (klickbar)
--}}
@props(['flush' => false, 'hover' => false])
<div {{ $attributes->class(['nx-card', 'is-pad' => ! $flush, 'is-hover' => $hover]) }}>
    {{ $slot }}
</div>
