@props([
    'model' => '',
    'label' => '',
    'variant' => 'primary', // primary, success, danger, warning
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'description' => null,
])

@php
    $variants = [
        'primary' => 'bg-[var(--ui-primary)] text-[var(--ui-on-primary)]',
        'success' => 'bg-[var(--ui-success)] text-[var(--ui-on-success)]',
        'danger' => 'bg-[var(--ui-danger)] text-[var(--ui-on-danger)]',
        'warning' => 'bg-[var(--ui-warning)] text-[var(--ui-on-warning)]',
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
@endphp

<div class="flex items-center justify-between p-4 bg-white rounded-lg border border-[var(--ui-border)]/60 hover:border-[var(--ui-primary)]/40 transition-colors">
    <div class="flex items-center space-x-3">
        @if($icon)
            <div class="flex-shrink-0">
                @svg('heroicon-o-' . $icon, 'w-5 h-5 text-[var(--ui-muted)]')
            </div>
        @endif
        
        <div>
            <div class="font-medium text-[var(--ui-secondary)]">{{ $label }}</div>
            @if($description)
                <div class="text-sm text-[var(--ui-muted)]">{{ $description }}</div>
            @endif
        </div>
    </div>
    
    <div class="flex items-center">
        <label class="relative inline-flex items-center cursor-pointer">
            <input 
                type="checkbox" 
                wire:model.live="{{ $model }}"
                class="sr-only peer"
            >
            <div class="w-11 h-6 bg-[var(--ui-muted)] rounded-full peer peer-focus:ring-4 peer-focus:ring-[var(--ui-primary)]/20 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:{{ $variants[$variant] }}"></div>
        </label>
    </div>
</div>
