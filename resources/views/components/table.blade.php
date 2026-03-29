@props([
    'compact' => false,
])

@php
    $tableTextSize = $compact ? 'text-sm' : 'text-base';
@endphp

<div class="bg-[color:var(--ui-surface)] rounded-lg border-4 border-red-500 overflow-hidden shadow-lg">
    <table class="w-full border-collapse {{ $tableTextSize }}">
        {{ $slot }}
    </table>
</div>
