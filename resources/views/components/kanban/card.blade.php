{{--
  Component: Kanban Card (Molecule)
  Zweck: Einzelne Karte im Kanban-Board mit Sortier-Funktionalität.
  Props:
    - title: string - Karten-Titel
    - sortableId: string|null - ID für Sortierung
    - href: string|null - Link-URL
    - footer: string|null - Footer-Inhalt
--}}

@props([
    'title' => 'Card-Titel',
    'sortableId' => null,
    'href' => null,
    'footer' => null,
])

@php
    $sortableAttributes = $sortableId
        ? [
            'wire:sortable-group.item' => $sortableId,
            'wire:sortable-group.handle' => true,
        ]
        : [];

    $interactiveAttributes = $href
        ? [
            'x-data' => true,
            '@click' => '$refs.navlink.click()',
            'style' => 'cursor: pointer;',
        ]
        : [];

    $classes = 'rounded-lg p-3 bg-[var(--ui-surface)] border border-[color:var(--ui-border)]/60 mb-2 shadow-sm hover:shadow-md transition-shadow';

    $mergedAttributes = $attributes->merge(
        array_merge(
            ['class' => $classes],
            $sortableAttributes,
            $interactiveAttributes
        )
    );
@endphp

<div {{ $mergedAttributes }}>
    <!-- Header (nie klickbar) -->
    @if(!is_null($title) && $title !== '')
        <div class="px-1.5 py-1">
            <h4 class="text-xs text-[color:var(--ui-secondary)] font-semibold leading-snug m-0 line-clamp-2">{{ $title }}</h4>
        </div>
    @endif

    <!-- Body -->
    <div class="px-1.5 text-xs text-[color:var(--ui-muted)] space-y-1">
        {{ $slot }}
    </div>

    @if($href)
        <!-- Unsichtbarer wire:navigate-Link -->
        <a
            x-ref="navlink"
            href="{{ $href }}"
            wire:navigate
            tabindex="-1"
            style="display: none"></a>
    @endif

    <!-- Footer (nie klickbar) -->
    @if($footer)
        <div class="px-1.5 flex justify-between items-center text-xs">
            {{ $footer }}
        </div>
    @endif
</div>