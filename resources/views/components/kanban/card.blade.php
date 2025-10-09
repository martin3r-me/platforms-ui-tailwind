@props([
    'title' => null,
    'footer' => null,
    'sortableId' => null,
    'href' => null,
    'view' => 'board', // 'board' oder 'list'
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

    $classes = $view === 'list' 
        ? 'rounded-lg p-3 bg-[var(--ui-surface)] border border-[color:var(--ui-border)]/60 mb-2 shadow-sm hover:shadow-md transition-shadow flex items-center gap-3'
        : 'rounded-lg p-2 bg-[var(--ui-surface)] border border-[color:var(--ui-border)]/60 mb-2 shadow-sm hover:shadow-md transition-shadow';

    $mergedAttributes = $attributes->merge(
        array_merge(
            ['class' => $classes],
            $sortableAttributes,
            $interactiveAttributes
        )
    );
@endphp

{{-- Board View --}}
<div 
    x-show="Alpine.store('plannerKanbanView') === 'board'"
    x-cloak
    {{ $mergedAttributes }}
>
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
        <a x-ref="navlink" href="{{ $href }}" wire:navigate tabindex="-1" style="display: none"></a>
    @endif

    <!-- Footer (nie klickbar) -->
    @if($footer)
        <div class="px-1.5 flex justify-between items-center text-xs">
            {{ $footer }}
        </div>
    @endif
</div>

{{-- List View --}}
<div 
    x-show="Alpine.store('plannerKanbanView') === 'list'"
    x-cloak
    {{ $mergedAttributes }}
>
    <!-- Drag Handle -->
    @if($sortableId)
        <div class="flex-shrink-0 text-[color:var(--ui-muted)] cursor-grab">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
            </svg>
        </div>
    @endif

    <!-- Content -->
    <div class="flex-1 min-w-0">
        @if(!is_null($title) && $title !== '')
            <h4 class="text-sm text-[color:var(--ui-secondary)] font-semibold leading-snug m-0 mb-1">{{ $title }}</h4>
        @endif
        
        <div class="text-sm text-[color:var(--ui-muted)]">
            {{ $slot }}
        </div>
    </div>

    @if($href)
        <a x-ref="navlink" href="{{ $href }}" wire:navigate tabindex="-1" style="display: none"></a>
    @endif

    <!-- Footer -->
    @if($footer)
        <div class="flex-shrink-0 text-xs">
            {{ $footer }}
        </div>
    @endif
</div>