@props([
    'sortable' => null,
    'sortableGroup' => null,
    'showToggle' => false,
    'view' => 'board',
])

<div class="flex-1 min-h-0 h-full overflow-x-auto overflow-y-hidden">
    <x-ui-kanban-board 
        {{ $attributes->merge([
            'class' => 'h-full',
            'wire:sortable' => $sortable,
            'wire:sortable-group' => $sortableGroup,
            'show-toggle' => $showToggle,
            'view' => $view,
        ]) }}
    >
        {{ $slot }}
    </x-ui-kanban-board>
</div>
