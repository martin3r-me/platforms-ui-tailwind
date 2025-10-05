@props([
    'compact' => false,
    'sortable' => false,
    'sortField' => null,
    'currentSort' => null,
    'sortDirection' => 'asc',
    'align' => 'left', // left, center, right
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
        $sortClasses = 'text-primary font-bold';
    }
@endphp

<th class="{{ $paddingClass }} {{ $alignClass }} font-semibold text-secondary border-bottom-1 border-bottom-muted border-bottom-solid border-right-1 border-right-muted border-right-solid bg-muted-5 {{ $sortClasses }}">
    @if($sortable)
        <button 
            type="button" 
            class="d-flex items-center gap-1 hover:text-primary transition-colors"
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
                @svg('heroicon-o-chevron-up-down', 'w-4 h-4 text-muted')
            @endif
        </button>
    @else
        {{ $slot }}
    @endif
</th>
