@props([
    'label' => '',
    'subtitle' => '',
    'selected' => false,
    'badge' => null, // ['text' => '3', 'variant' => 'info']
])

@php
    $classes = collect([
        'cursor-pointer px-3 py-2 rounded transition-all d-flex justify-between items-center',
        'hover:bg-muted-10',
        $selected ? 'bg-muted font-semibold text-primary' : '',
    ])->filter()->implode(' ');
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex-grow">
        <div class="text-sm leading-tight">{{ $label }}</div>
        @if ($subtitle)
            <div class="text-xs text-muted-foreground">{{ $subtitle }}</div>
        @endif
    </div>

    @if ($badge && isset($badge['text']))
        <x-ui-badge 
            :variant="$badge['variant'] ?? 'info'" 
            size="xs"
            class="ml-2 shrink-0"
        >
            {{ $badge['text'] }}
        </x-ui-badge>
    @endif
</li>