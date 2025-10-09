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

    $classes = 'px-3 py-2 bg-white hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-b-0';

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
    :class="{ 'px-3 py-2 border-b border-gray-100 last:border-b-0': isList, 'rounded-lg p-3 shadow-sm border border-gray-200 mb-2': !isList }">
    @if(!is_null($title) && $title !== '')
        <div class="mb-2">
            <h4 class="text-sm font-semibold text-gray-900 m-0">{{ $title }}</h4>
        </div>
    @endif

    <div class="text-sm text-gray-600">
        {{ $slot }}
    </div>

    <!-- Buttons für Aktionen -->
    <div class="mt-2 flex justify-end gap-2">
        <button type="button" class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs border border-gray-300 hover:bg-gray-50">
            <svg viewBox="0 0 20 20" fill="currentColor" class="mr-1.5 -ml-0.5 size-4 text-gray-400">
                <path d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" fill-rule="evenodd" />
            </svg>
            <span>Phone</span>
        </button>
        <button type="button" class="relative inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs border border-gray-300 hover:bg-gray-50">
            <svg viewBox="0 0 20 20" fill="currentColor" class="mr-1.5 -ml-0.5 size-4 text-gray-400">
                <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
            </svg>
            <span>Email</span>
        </button>
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
        <div class="mt-2 pt-2 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
            {{ $footer }}
        </div>
    @endif
</div>