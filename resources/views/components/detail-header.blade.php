{{--
    x-ui-detail-header — Kopf einer Detailseite (nx-gestylt): Titel (optional Link),
    optionaler Badge, Meta-Zeilen (Icon + Text). Optionaler actions-Slot.

    <x-ui-detail-header :title="$name" :href="$route"
        :badge="['label' => 'inaktiv', 'variant' => 'muted']"
        :meta="[['icon' => 'heroicon-o-users', 'text' => '12 Beschäftigte']]" />
--}}
@props([
    'title' => null,
    'href' => null,
    'badge' => null,
    'meta' => [],
])

@php
    $bv = is_array($badge) ? ($badge['variant'] ?? 'neutral') : 'neutral';
    $badgeColor = [
        'success' => 'var(--nx-success)',
        'danger'  => 'var(--nx-danger)',
        'warning' => 'var(--nx-warning)',
        'info'    => 'var(--nx-info)',
        'accent'  => 'var(--nx-accent)',
    ][$bv] ?? 'var(--nx-muted)';
@endphp

<div {{ $attributes->class('rounded-[8px] bg-[color:var(--nx-surface)] border border-[color:var(--nx-line)] p-4') }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                @if($href)
                    <a href="{{ $href }}" wire:navigate class="truncate text-lg font-semibold text-[color:var(--nx-text)] hover:underline">{{ $title }}</a>
                @else
                    <h1 class="m-0 truncate text-lg font-semibold text-[color:var(--nx-text)]">{{ $title }}</h1>
                @endif
                @if(is_array($badge) && !empty($badge['label']))
                    <span class="inline-flex shrink-0 items-center rounded-full border border-[color:var(--nx-line)] px-2 py-0.5 text-xs font-medium" style="color:{{ $badgeColor }}">{{ $badge['label'] }}</span>
                @endif
            </div>
            @if(!empty($meta))
                <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-1">
                    @foreach($meta as $m)
                        @if(!empty($m['text']))
                            <span class="inline-flex items-center gap-1 text-xs text-[color:var(--nx-muted)]">
                                @if(!empty($m['icon']))
                                    @svg($m['icon'], 'w-3.5 h-3.5 shrink-0 text-[color:var(--nx-faint)]')
                                @endif
                                {{ $m['text'] }}
                            </span>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        @isset($actions)
            <div class="shrink-0">{{ $actions }}</div>
        @endisset
    </div>
</div>
