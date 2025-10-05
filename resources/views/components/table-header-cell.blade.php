@props([
    'compact' => false,
    'sortable' => false,
    'sortField' => null,
    'currentSort' => null,
    'sortDirection' => 'asc',
    'align' => 'left',
])

@php
    $paddingClass = $compact ? 'p-1' : 'p-3';
    $alignClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
    $sortClasses = '';
    if ($sortable && $currentSort === $sortField) {
        $sortClasses = 'text-[color:var(--ui-primary)] font-bold';
    }
@endphp

<th class="{{ $paddingClass }} {{ $alignClass }} font-semibold text-[color:var(--ui-body-color)] border-b border-[color:var(--ui-border)] bg-[color:var(--ui-muted-5)] {{ $sortClasses }}">
    @if($sortable)
        <button 
            type="button" 
            class="flex items-center gap-1 hover:text-[color:var(--ui-primary)] transition-colors"
            wire:click="sortBy('{{ $sortField }}')"
        >
            {{ $slot }}
            @if($currentSort === $sortField)
                @if($sortDirection === 'asc')
                    @svg('heroicon-o-chevron-up', 'w-4 h-4')
                @else
                    @svg('heroicon-o-chevron-down', 'w-4 h-4')
                @endif
            @else
                @svg('heroicon-o-chevron-up-down', 'w-4 h-4 text-[color:var(--ui-muted)]')
            @endif
        </button>
    @else
        {{ $slot }}
    @endif
</th>
