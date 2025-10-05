<div 
    {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
        'class' => 'h-full w-full flex gap-1 overflow-x-auto'
    ]) }}
>
    {{ $slot }}
</div>