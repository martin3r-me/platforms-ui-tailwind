@props([
    'striped' => true,
    'hover' => true,
    'bordered' => true,
    'compact' => false,
])

@php
    $tableTextSize = $compact ? 'text-sm' : 'text-base';
@endphp

<div class="bg-[color:var(--ui-surface)] rounded-lg border border-[color:var(--ui-border)] overflow-hidden shadow-sm">
    <table class="w-full border-collapse {{ $tableTextSize }}">
        {{ $slot }}
    </table>
</div>
