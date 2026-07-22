{{--
    nx-callout — Notion-Callout: getönter Grund + farbiges Icon + Text.
    Trägt die (bedeutungstragende) Farbe im Inhalt; Chrome bleibt neutral.

    <x-nx-callout variant="warning" title="3 Buchungen offen">
        warten auf Bestätigung
        <x-slot name="action"><x-nx-button ...>Ansehen</x-nx-button></x-slot>
    </x-nx-callout>

      variant : info (default) | success | warning | danger | neutral
      icon    : optionales Heroicon (sonst Variant-Standard)
      title   : optionale fette Zeile
--}}
@props([
    'variant' => 'info',
    'icon' => null,
    'title' => null,
])

@php
    [$bg, $fg, $defaultIcon] = match ($variant) {
        'success' => ['rgba(47,158,68,.09)', 'var(--nx-success)', 'heroicon-o-check-circle'],
        'warning' => ['rgba(232,89,12,.09)', 'var(--nx-warning)', 'heroicon-o-exclamation-triangle'],
        'danger'  => ['rgba(224,49,49,.09)', 'var(--nx-danger)', 'heroicon-o-x-circle'],
        'neutral' => ['var(--nx-accent-soft)', 'var(--nx-muted)', 'heroicon-o-information-circle'],
        default   => ['rgba(25,113,194,.09)', 'var(--nx-info)', 'heroicon-o-information-circle'],
    };
    $glyph = $icon ?: $defaultIcon;
@endphp

<div {{ $attributes->class('flex items-start gap-3 rounded-[8px] p-4 text-sm') }} style="background:{{ $bg }}">
    @svg($glyph, 'mt-px h-5 w-5 shrink-0', ['style' => 'color:' . $fg])
    <div class="min-w-0 flex-1 text-[color:var(--nx-text)]">
        @if ($title)
            <div class="font-semibold">{{ $title }}</div>
        @endif
        @if (trim($slot))
            <div class="{{ $title ? 'mt-0.5 text-[color:var(--nx-muted)]' : '' }}">{{ $slot }}</div>
        @endif
        @isset($action)
            <div class="mt-2">{{ $action }}</div>
        @endisset
    </div>
</div>
