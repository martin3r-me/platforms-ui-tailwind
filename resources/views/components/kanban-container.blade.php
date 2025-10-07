@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div class="flex-1 min-h-0 overflow-x-auto">
    <x-ui-kanban-board 
        @if($sortable) wire:sortable="{{ $sortable }}" @endif
        @if($sortableGroup) wire:sortable-group="{{ $sortableGroup }}" @endif
        class="h-full"
    >
        {{ $slot }}
    </x-ui-kanban-board>
</div>
