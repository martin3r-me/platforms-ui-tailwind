@props([
    'title' => 'Unbenannt',
    'sortableId' => null,
    'scrollable' => true,
    'footer' => null,
])

<div 
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'kanban-column flex-shrink-0 h-full w-80 flex flex-col']) }}
    x-data="{ isList: localStorage.getItem('kanbanView') === 'list', scrollable: {{ $scrollable ? 'true' : 'false' }} }"
    x-init="this.isList = localStorage.getItem('kanbanView') === 'list'"
    @storage-change.window="isList = localStorage.getItem('kanbanView') === 'list'"
    :class="{ 'w-full': isList, 'w-80': !isList }"
>
    <div class="flex flex-col h-full bg-[var(--ui-surface)] border border-[var(--ui-border)]/40">
        
        <!-- Header -->
        <div 
            class="px-3 py-2.5 text-xs font-medium flex justify-between items-center"
            :class="{ 'bg-[var(--ui-muted-5)]': isList, 'bg-[var(--ui-surface)]': !isList }"
        >
            <span class="text-[var(--ui-secondary)] flex-1 truncate">{{ $title }}</span>
            
            <div class="flex items-center gap-2">
                @isset($headerActions)
                    <div class="flex items-center gap-1">
                        {{ $headerActions }}
                    </div>
                @endisset
                
                @if($sortableId)
                    <button wire:sortable.handle class="text-[var(--ui-muted)] hover:text-[var(--ui-primary)] cursor-grab p-1 rounded-md hover:bg-[var(--ui-muted-5)]" title="Spalte verschieben">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div 
            wire:sortable-group.item-group="{{ $sortableId }}" 
            class="flex-1 min-h-0"
            :class="{ '': isList, 'px-1.5 py-2': !isList, 'overflow-y-auto': scrollable }"
        >
            {{ $slot }}
        </div>

        @if($footer)
            <div class="px-3 py-2.5 border-t border-[var(--ui-border)]/30 bg-[var(--ui-muted-5)]">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

<style>
    /* Column Drag-Zustände dezent halten */
    .kanban-column.wire-dragging .flex.flex-col.h-full {
        background: var(--ui-surface);
        opacity: .96;
    }
    .kanban-column.wire-sortable-placeholder .flex.flex-col.h-full {
        background: var(--ui-muted-5) !important;
        border: 1px dashed var(--ui-border);
    }
</style>