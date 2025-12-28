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
            '@click' => '$refs.navlink.click()',
            'style' => 'cursor: pointer;',
        ]
        : [];

    // Basis-Styles: bewusst schlicht, aber sauber und stabil beim Drag
    $classes = 'kanban-card px-3 py-3 bg-[var(--ui-muted-5)] hover:bg-[var(--ui-muted-10)] transition-colors';

    $mergedAttributes = $attributes->merge(
        array_merge(
            ['class' => $classes],
            $sortableAttributes,
            $interactiveAttributes
        )
    );
@endphp

<div {{ $mergedAttributes }} 
    x-data="{ isList: localStorage.getItem('kanbanView') === 'list' }"
    x-init="this.isList = localStorage.getItem('kanbanView') === 'list'"
    @storage-change.window="isList = localStorage.getItem('kanbanView') === 'list'"
    :class="{ 'border-b last:border-b-0 rounded-none': isList, 'my-2 mx-2': !isList }">
    @if(!is_null($title) && $title !== '')
        <div class="mb-3">
            <h4 class="text-sm font-medium text-[var(--ui-secondary)] m-0">{{ $title }}</h4>
        </div>
    @endif

    <div class="text-sm text-[var(--ui-muted)]">
        {{ $slot }}
    </div>

    @if($href)
        <a
            x-ref="navlink"
            href="{{ $href }}"
            wire:navigate
            tabindex="-1"
            style="display: none"></a>
    @endif

    @if($footer)
        <div class="mt-3 pt-3 border-t border-[var(--ui-border)]/30 flex justify-between items-center text-xs text-[var(--ui-muted)]">
            {{ $footer }}
        </div>
    @endif
</div>

<style>
    /* Drag-Zustände von Livewire Sortable stabilisieren */
    .kanban-card wire\:sortable-group\:item,
    .kanban-card {
        background: var(--ui-muted-5);
    }
    .kanban-card.wire-dragging {
        opacity: .9; /* leichtes Feedback, aber nicht transparent */
        background: var(--ui-muted-10);
    }
    .kanban-card.wire-sortable-placeholder {
        background: var(--ui-muted-5) !important;
        border: 1px dashed var(--ui-border);
        min-height: 3rem;
    }
</style>