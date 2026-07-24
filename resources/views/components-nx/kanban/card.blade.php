{{--
    nx-kanban-card — flache Notion-Karte fürs Board. API-kompatibel zu
    x-ui-kanban-card (title, href, footer, sortableId). Kein Schatten/Lift:
    Hairline-Rand auf Surface, dezenter Hover. In der Listen-Ansicht wird die
    Karte zur flachen Zeile (nur untere Hairline).

      title      : optionaler Kartentitel
      sortableId : aktiviert Drag (wire:sortable-group.item)
      href       : macht die Karte klickbar (wire:navigate)
      footer     : Slot für Meta-Zeile unten
--}}
@props([
    'title' => null,
    'sortableId' => null,
    'href' => null,
    'footer' => null,
])

@php
    $sortableAttributes = $sortableId
        ? ['wire:sortable-group.item' => $sortableId, 'wire:sortable-group.handle' => true]
        : [];

    $interactiveAttributes = $href
        ? ['@click' => '$refs.navlink.click()', 'style' => 'cursor: pointer;']
        : [];

    $classes = 'kanban-card rounded-[8px] border border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] px-3 py-2.5 shadow-[var(--nx-shadow-card)] transition-shadow hover:shadow-[0_2px_8px_rgba(15,15,15,.08),0_1px_2px_rgba(15,15,15,.05)]';

    $mergedAttributes = $attributes->merge(
        array_merge(['class' => $classes], $sortableAttributes, $interactiveAttributes)
    );
@endphp

<div {{ $mergedAttributes }}
    x-data="{ isList: localStorage.getItem('kanbanView') === 'list' }"
    x-init="this.isList = localStorage.getItem('kanbanView') === 'list'"
    @storage-change.window="isList = localStorage.getItem('kanbanView') === 'list'"
    :class="{ 'rounded-none border-x-0 border-t-0 shadow-none hover:shadow-none': isList, 'mx-1 my-2': !isList }">

    @if(!is_null($title) && $title !== '')
        <div class="mb-1.5">
            <h4 class="m-0 text-sm font-medium text-[color:var(--nx-text)]">{{ $title }}</h4>
        </div>
    @endif

    <div class="text-sm text-[color:var(--nx-muted)]">
        {{ $slot }}
    </div>

    @if($href)
        <a x-ref="navlink" href="{{ $href }}" wire:navigate tabindex="-1" style="display: none"></a>
    @endif

    @if($footer)
        <div class="mt-2.5 flex items-center justify-between border-t border-[color:var(--nx-line)] pt-2.5 text-xs text-[color:var(--nx-muted)]">
            {{ $footer }}
        </div>
    @endif
</div>

<style>
    /* Drag-Zustände (Livewire Sortable) — flach, nx-Tokens */
    .kanban-card.wire-dragging {
        opacity: .9;
        border-color: var(--nx-line-strong);
    }
    .kanban-card.wire-sortable-placeholder {
        background: var(--nx-hover) !important;
        border: 1px dashed var(--nx-line-strong) !important;
        min-height: 3rem;
    }
</style>
