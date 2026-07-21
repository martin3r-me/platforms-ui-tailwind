{{--
    nx-card — Notion-Grundfläche (surface + Hairline, kein Schatten).
    Reines Tailwind mit --nx-* Tokens (siehe safelist.txt).

    <x-nx-card>…</x-nx-card>        Standard, mit Padding
    <x-nx-card flush>…</x-nx-card>   ohne Padding
    <x-nx-card hover>…</x-nx-card>   dezente Hover-Fläche (klickbar)
--}}
@props(['flush' => false, 'hover' => false])
<div {{ $attributes->class([
    'rounded-[8px] bg-[color:var(--nx-surface)] border border-[color:var(--nx-line)] text-[color:var(--nx-text)]',
    'p-4' => ! $flush,
    'transition-colors cursor-pointer hover:bg-[color:var(--nx-hover)]' => $hover,
]) }}>
    {{ $slot }}
</div>
