@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
    'class' => 'h-full w-full space-y-6 overflow-y-auto p-2'
]) }}>
    {{ $slot }}
</div>
