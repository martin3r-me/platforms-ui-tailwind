@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div class="flex-1 min-h-0 overflow-x-auto">
    <x-ui-kanban-board 
        {{ $attributes->merge([
            'class' => 'h-full',
            'wire:sortable' => $sortable,
            'wire:sortable-group' => $sortableGroup,
        ]) }}
    >
        {{ $slot }}
    </x-ui-kanban-board>
</div>
