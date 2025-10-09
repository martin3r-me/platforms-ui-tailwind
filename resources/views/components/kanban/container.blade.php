@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div class="flex-1 min-h-0 h-full p-4">
    <x-ui-kanban-board 
        wire:sortable="{{ $sortable }}"
        wire:sortable-group="{{ $sortableGroup }}"
        class="h-full"
    >
        {{ $slot }}
    </x-ui-kanban-board>
</div>
