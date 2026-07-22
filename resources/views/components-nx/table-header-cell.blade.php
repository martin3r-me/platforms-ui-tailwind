@props([
    'compact' => false,
    'sortable' => false,
    'sortField' => null,
    'currentSort' => null,
    'sortDirection' => 'asc',
    'align' => 'left',
])

@php
    $pad = $compact ? 'px-2.5 py-2' : 'px-3 py-2.5';
    $al = match ($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
    $active = $sortable && $currentSort === $sortField;
@endphp

<th {{ $attributes->class([
    $pad, $al,
    'border-b border-[color:var(--nx-line)] text-xs font-medium whitespace-nowrap',
    'text-[color:var(--nx-text)]' => $active,
    'text-[color:var(--nx-muted)]' => ! $active,
]) }}>
    @if ($sortable)
        <button type="button" wire:click="sortBy('{{ $sortField }}')"
            class="inline-flex items-center gap-1 transition-colors hover:text-[color:var(--nx-text)] {{ $align === 'right' ? 'flex-row-reverse' : '' }}">
            {{ $slot }}
            @if ($active)
                @svg($sortDirection === 'asc' ? 'heroicon-o-chevron-up' : 'heroicon-o-chevron-down', 'w-3.5 h-3.5')
            @else
                @svg('heroicon-o-chevron-up-down', 'w-3.5 h-3.5 opacity-50')
            @endif
        </button>
    @else
        {{ $slot }}
    @endif
</th>
