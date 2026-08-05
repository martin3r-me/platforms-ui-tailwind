{{--
    x-ui-stat-tiles — KPI-Kachelzeile (nx-gestylt).
    <x-ui-stat-tiles :items="[
        ['label' => 'Beschäftigte', 'value' => $total, 'icon' => 'heroicon-o-users'],
        ['label' => 'Aktiv', 'value' => $aktiv, 'icon' => 'heroicon-o-check-circle', 'accent' => 'var(--nx-success)'],
    ]" />
    Item-Keys: label, value, icon (optional), accent (optional CSS-Farbe), hint (optional).
--}}
@props(['items' => []])

<div {{ $attributes->class('flex flex-wrap gap-3') }}>
    @foreach($items as $item)
        <div class="flex-1 min-w-[160px] rounded-[8px] border border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] p-4">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-medium text-[color:var(--nx-muted)]">{{ $item['label'] ?? '' }}</span>
                @if(!empty($item['icon']))
                    @if(!empty($item['accent']))
                        @svg($item['icon'], 'w-4 h-4 shrink-0', ['style' => 'color:'.$item['accent']])
                    @else
                        @svg($item['icon'], 'w-4 h-4 shrink-0 text-[color:var(--nx-faint)]')
                    @endif
                @endif
            </div>
            <div class="mt-2 whitespace-nowrap text-2xl font-semibold tabular-nums text-[color:var(--nx-text)]">{{ $item['value'] ?? '—' }}</div>
            @if(!empty($item['hint']))
                <div class="mt-0.5 text-xs text-[color:var(--nx-faint)]">{{ $item['hint'] }}</div>
            @endif
        </div>
    @endforeach
</div>
