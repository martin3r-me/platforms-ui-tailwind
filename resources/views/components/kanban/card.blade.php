@props([
    'title' => 'Card-Titel',
    'footer' => null,
    'sortableId' => null,
    'href' => null,
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

    $classes = 'rounded-lg p-1 shadow-md bg-white border border-[color:var(--ui-border)] mb-1';

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
    <div class="px-2 py-1 flex">
        <h4 class="text-xs text-[color:var(--ui-muted)] font-semibold m-0">{{ $title }}</h4>
    </div>

    <!-- Body -->
    <div class="px-2 text-sm">
        {{ $slot }}
    </div>

    @if($href)
        <a x-ref="navlink" href="{{ $href }}" wire:navigate tabindex="-1" style="display: none"></a>
    @endif

    <!-- Footer (nie klickbar) -->
    @if($footer)
        <div class="px-2 flex justify-between items-center">
            {{ $footer }}
        </div>
    @endif
</div>