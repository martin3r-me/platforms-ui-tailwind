@props([
    'label' => '',
    'subtitle' => '',
    'selected' => false,
    'badge' => null,
])

@php
    $classes = collect([
        'cursor-pointer px-3 py-2 rounded transition-all flex justify-between items-center',
        'hover:bg-[color:var(--ui-muted-10)]',
        $selected ? 'bg-[color:var(--ui-muted-5)] font-semibold text-[color:var(--ui-primary)]' : '',
    ])->filter()->implode(' ');
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex-1">
        <div class="text-sm leading-tight">{{ $label }}</div>
        @if ($subtitle)
            <div class="text-xs text-[color:var(--ui-muted)]">{{ $subtitle }}</div>
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