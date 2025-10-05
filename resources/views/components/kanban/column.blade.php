@props([
    'title' => 'Unbenannt',
    'footer' => null,
    'scrollable' => true,
    'sortableId' => null,
])

<div 
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'shrink-0 h-full w-80 flex flex-col']) }}
>
    <div class="flex flex-col h-full bg-[color:var(--ui-surface)]">
        <!-- Header -->
        <div class="p-3 text-base font-semibold uppercase tracking-wide flex justify-between items-center">
            {{ $title }}
            <button wire:sortable.handle class="text-[color:var(--ui-primary)]" title="Spalte verschieben" style="cursor: grab;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                </svg>
            </button>
        </div>

        @isset($extra)
            <div class="p-2 border-b border-[color:var(--ui-border)] bg-[color:var(--ui-surface)]">
                {{ $extra }}
            </div>
        @endisset

        <!-- Body -->
        <div wire:sortable-group.item-group="{{ $sortableId }}" class="flex-1 px-3 py-3 gap-3 flex flex-col {{ $scrollable ? 'overflow-y-auto' : '' }}">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if($footer)
            <div class="px-4 py-3 border-t border-[color:var(--ui-border)] bg-[color:var(--ui-surface)]">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>