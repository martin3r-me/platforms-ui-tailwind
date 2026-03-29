@props([
    'compact' => false,
])

@php
    $tableTextSize = $compact ? 'text-sm' : 'text-base';
@endphp

<div class="bg-[color:var(--ui-surface)] rounded-xl border border-white/30 overflow-hidden shadow-[0_1px_3px_rgba(0,0,0,0.04)] backdrop-blur-sm">
    <table class="w-full border-collapse {{ $tableTextSize }}">
        {{ $slot }}
    </table>
</div>
