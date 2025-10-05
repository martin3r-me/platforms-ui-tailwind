@props([
    'striped' => true,
    'hover' => true,
    'bordered' => true,
    'compact' => false,
])

<div class="bg-[color:var(--ui-surface)] rounded-lg border border-[color:var(--ui-border)] overflow-hidden shadow-sm">
    <table class="w-full border-collapse">
        {{ $slot }}
    </table>
</div>
