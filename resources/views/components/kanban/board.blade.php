<div {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
    'class' => 'h-full w-full flex gap-4 overflow-x-auto overflow-y-hidden p-2'
]) }}>
    {{ $slot }}
</div>