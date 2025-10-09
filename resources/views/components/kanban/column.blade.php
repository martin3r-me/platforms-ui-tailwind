@props([
    'title' => 'Unbenannt',
    'footer' => null,
    'scrollable' => true,
    'sortableId' => null,
    'muted' => false,
    'view' => 'board', // 'board' oder 'list'
])

{{-- Board View --}}
<div 
    x-show="view === 'board'"
    x-cloak
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'shrink-0 h-full w-80 flex flex-col']) }}
>
    <div class="flex flex-col h-full rounded-lg border {{ $muted ? 'border-[color:var(--ui-border)]/40 bg-[var(--ui-muted-5)]' : 'border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)]' }} shadow-sm">
        <!-- Header -->
        <div class="p-3 text-xs font-semibold tracking-wide flex justify-between items-center gap-2 sticky top-0 z-10 rounded-t-lg border-b {{ $muted ? 'border-[color:var(--ui-border)]/40 bg-[var(--ui-muted-5)]' : 'border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur' }}">
            <span class="uppercase {{ $muted ? 'text-[color:var(--ui-muted)]' : 'text-[color:var(--ui-secondary)]' }} flex-1 truncate">{{ $title }}</span>
            
            @isset($headerActions)
                <div class="flex items-center gap-1">
                    {{ $headerActions }}
                </div>
            @endisset
            
            @if($sortableId && !$muted)
                <button wire:sortable.handle class="text-[color:var(--ui-primary)] flex-shrink-0" title="Spalte verschieben" style="cursor: grab;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                    </svg>
                </button>
            @endif
        </div>

        <!-- Body -->
        <div wire:sortable-group.item-group="{{ $sortableId }}" class="flex-1 min-h-0 px-3 py-3 gap-3 flex flex-col {{ $scrollable ? 'overflow-y-auto' : '' }} {{ $muted ? 'bg-[var(--ui-muted-5)]/50' : '' }}">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if($footer)
            <div class="px-4 py-3 border-t border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)] rounded-b-lg">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>

{{-- List View --}}
<div 
    x-show="view === 'list'"
    x-cloak
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="list-column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'w-full mb-4']) }}
>
    <div class="rounded-lg border {{ $muted ? 'border-[color:var(--ui-border)]/40 bg-[var(--ui-muted-5)]' : 'border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)]' }} shadow-sm">
        <!-- Header -->
        <div class="p-3 text-xs font-semibold tracking-wide flex justify-between items-center gap-2 border-b {{ $muted ? 'border-[color:var(--ui-border)]/40 bg-[var(--ui-muted-5)]' : 'border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur' }}">
            <span class="uppercase {{ $muted ? 'text-[color:var(--ui-muted)]' : 'text-[color:var(--ui-secondary)]' }} flex-1 truncate">{{ $title }}</span>
            
            @isset($headerActions)
                <div class="flex items-center gap-1">
                    {{ $headerActions }}
                </div>
            @endisset
            
            @if($sortableId && !$muted)
                <button wire:sortable.handle class="text-[color:var(--ui-primary)] flex-shrink-0" title="Spalte verschieben" style="cursor: grab;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                    </svg>
                </button>
            @endif
        </div>

        <!-- Body - Liste statt Spalte -->
        <div wire:sortable-group.item-group="{{ $sortableId }}" class="p-3 space-y-2 {{ $muted ? 'bg-[var(--ui-muted-5)]/50' : '' }}">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if($footer)
            <div class="px-4 py-3 border-t border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)] rounded-b-lg">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>