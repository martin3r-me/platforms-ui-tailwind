<div {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
    'class' => 'h-full min-h-0 w-full flex gap-4 px-4 py-3 overflow-x-auto'
]) }}>
    {{ $slot }}
</div>
