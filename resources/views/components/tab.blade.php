@props([
    'tabs' => [],
    'model' => null, // wire:model Binding
    'showCounts' => false,
])

@php
    $modelBinding = $attributes->whereStartsWith('wire:model')->first();
    $modelName = $model ?? Str::after($modelBinding, 'wire:model=');
@endphp

<div class="inline-flex gap-2">
    @foreach($tabs as $tab)
        @php
            $isActive = $model && $model === $tab['value'];
        @endphp

        <x-ui-button
            wire:click="$set('{{ $modelName }}', '{{ $tab['value'] }}')"
            variant="{{ $isActive ? 'primary' : 'secondary-outline' }}"
            size="sm"
        >
            {{ $tab['label'] }}
            @if($showCounts && isset($tab['count']))
                <span class="ml-2 px-2 py-0.5 text-xs bg-[color:var(--ui-muted-5)] text-[color:var(--ui-body-color)] rounded-full">
                    {{ $tab['count'] }}
                </span>
            @endif
        </x-ui-button>
    @endforeach
</div>