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

    $classes = 'px-3 py-2 bg-[var(--ui-muted-5)] hover:bg-[var(--ui-muted-4)] transition-colors border-b border-[var(--ui-border)]/40 last:border-b-0';

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
    :class="{ 'px-3 py-2 border-b border-[var(--ui-border)]/40 last:border-b-0': isList, 'rounded-lg p-4 shadow-sm border border-[var(--ui-border)]/60 my-2 mx-2 bg-[var(--ui-muted-5)] hover:bg-[var(--ui-muted-4)]': !isList }">
    @if(!is_null($title) && $title !== '')
        <div class="mb-2">
            <h4 class="text-sm font-semibold text-[var(--ui-secondary)] m-0">{{ $title }}</h4>
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
        <div class="mt-2 pt-2 border-t border-[var(--ui-border)]/40 flex justify-between items-center text-xs text-[var(--ui-muted)]">
            {{ $footer }}
        </div>
    @endif
</div>