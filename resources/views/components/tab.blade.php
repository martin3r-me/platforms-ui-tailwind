@props([
    'tabs' => [],
    'model' => null, // wire:model Binding
    'showCounts' => false,
    'size' => 'sm', // 'xs', 'sm'
])

@php
    $modelBinding = $attributes->whereStartsWith('wire:model')->first();
    $modelName = $model ?? Str::after($modelBinding, 'wire:model=');

    $tabClasses = match($size) {
        'xs' => 'px-2 py-0.5 text-xs font-medium rounded-md',
        default => null, // use x-ui-button default
    };
    $countClasses = match($size) {
        'xs' => 'ml-1 px-1.5 py-0 text-[10px]',
        default => 'ml-2 px-2 py-0.5 text-xs',
    };
@endphp

<div class="inline-flex gap-1.5">
    @foreach($tabs as $tab)
        @php
            $isActive = $model && $model === $tab['value'];
        @endphp

        @if($size === 'xs')
            <button
                wire:click="$set('{{ $modelName }}', '{{ $tab['value'] }}')"
                class="inline-flex items-center gap-1 {{ $tabClasses }} transition-colors {{ $isActive
                    ? 'bg-[rgb(var(--ui-primary-rgb))] text-[color:var(--ui-on-primary)] shadow-sm'
                    : 'text-[color:var(--ui-secondary)] border border-[var(--ui-border)]/40 hover:bg-[var(--ui-muted-5)]' }}"
            >
                {{ $tab['label'] }}
                @if($showCounts && isset($tab['count']))
                    <span class="{{ $countClasses }} bg-[color:var(--ui-muted-5)] text-[color:var(--ui-body-color)] rounded-full">{{ $tab['count'] }}</span>
                @endif
            </button>
        @else
            <x-ui-button
                wire:click="$set('{{ $modelName }}', '{{ $tab['value'] }}')"
                variant="{{ $isActive ? 'primary' : 'secondary-outline' }}"
                size="sm"
            >
                {{ $tab['label'] }}
                @if($showCounts && isset($tab['count']))
                    <span class="{{ $countClasses }} bg-[color:var(--ui-muted-5)] text-[color:var(--ui-body-color)] rounded-full">{{ $tab['count'] }}</span>
                @endif
            </x-ui-button>
        @endif
    @endforeach
</div>