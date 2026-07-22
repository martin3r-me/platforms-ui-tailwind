{{--
    nx-stat — eine Kennzahl (Label + Wert, optional Hinweis/Icon). Optional Link.

    <x-nx-stat label="Offene Buchungen" value="3" hint="warten auf Bestätigung"
               icon="heroicon-o-inbox" :href="route(...)" accent="var(--nx-warning)" wire:navigate />

      label / value / hint : Texte
      icon                 : optionales Heroicon
      accent               : CSS-Farbe fürs Icon (optional; sonst faint)
      href                 : rendert <a> (klickbar, Hover) statt <div>
--}}
@props([
    'label' => '',
    'value' => '',
    'hint' => null,
    'icon' => null,
    'href' => null,
    'accent' => null,
])

@php
    $tag = $href ? 'a' : 'div';
    $classes = [
        'block rounded-[8px] border border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] p-4',
        'transition-colors hover:bg-[color:var(--nx-hover)]' => (bool) $href,
    ];
@endphp

<{{ $tag }} @if ($href) href="{{ $href }}" @endif {{ $attributes->class($classes) }}>
    <div class="flex items-center justify-between gap-2">
        <span class="text-xs font-medium text-[color:var(--nx-muted)]">{{ $label }}</span>
        @if ($icon)
            @if ($accent)
                @svg($icon, 'w-4 h-4 shrink-0', ['style' => 'color:' . $accent])
            @else
                @svg($icon, 'w-4 h-4 shrink-0 text-[color:var(--nx-faint)]')
            @endif
        @endif
    </div>
    <div class="mt-2 whitespace-nowrap text-2xl font-semibold tabular-nums text-[color:var(--nx-text)]">{{ $value }}</div>
    @if ($hint)
        <div class="mt-0.5 text-xs text-[color:var(--nx-faint)]">{{ $hint }}</div>
    @endif
</{{ $tag }}>
