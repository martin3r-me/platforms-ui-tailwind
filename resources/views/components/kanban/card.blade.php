@props([
    'title' => null,
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

    $classes = 'rounded-lg p-2 shadow-sm bg-white border border-[color:var(--ui-border)]/60 mb-2 hover:shadow-md transition-shadow';

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
        <div class="px-1.5 py-1 flex">
            <h4 class="text-xs text-[color:var(--ui-secondary)] font-medium m-0">{{ $title }}</h4>
        </div>
    @endif

    <!-- Body -->
    <div class="px-1.5 text-xs text-[color:var(--ui-muted)]">
        {{ $slot }}
    </div>

    @if($href)
        <a x-ref="navlink" href="{{ $href }}" wire:navigate tabindex="-1" style="display: none"></a>
    @endif

    <!-- Footer (nie klickbar) -->
    @if($footer)
        <div class="px-1.5 flex justify-between items-center text-xs">
            {{ $footer }}
        </div>
    @endif
</div>