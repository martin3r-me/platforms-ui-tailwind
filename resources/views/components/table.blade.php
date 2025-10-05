@props([
    'striped' => true,
    'hover' => true,
    'bordered' => true,
    'compact' => false,
])

<div class="bg-surface rounded-lg border border-muted overflow-hidden shadow-sm">
    <table class="w-full border-collapse">
        {{ $slot }}
    </table>
</div>
