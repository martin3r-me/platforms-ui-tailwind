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

    $classes = 'rounded-lg p-3 bg-white border border-gray-200 shadow-sm hover:shadow-md transition-shadow';

    $mergedAttributes = $attributes->merge(
        array_merge(
            ['class' => $classes],
            $sortableAttributes,
            $interactiveAttributes
        )
    );
@endphp

<div {{ $mergedAttributes }}>
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