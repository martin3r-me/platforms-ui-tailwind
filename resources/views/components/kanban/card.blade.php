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
    :class="{ 'px-3 py-2 border-b border-gray-100 last:border-b-0': isList, 'rounded-lg p-4 shadow-md border border-gray-200 my-2 mx-2': !isList }">
    @if(!is_null($title) && $title !== '')
        <div class="mb-2">
            <h4 class="text-sm font-semibold text-gray-900 m-0">{{ $title }}</h4>
        </div>
    @endif

    <div class="text-sm text-gray-600">
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
        <div class="mt-2 pt-2 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
            {{ $footer }}
        </div>
    @endif
</div>