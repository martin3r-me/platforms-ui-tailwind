@props([
    'label' => null,
])

<div x-show="!collapsed" class="px-2 py-2 border-b border-[var(--ui-border)]">
    @if($label)
        <div class="px-1 pb-2 text-xs uppercase tracking-wide text-[var(--ui-muted)]">{{ $label }}</div>
    @endif
    <div class="flex flex-col gap-1">
        {{ $slot }}
    </div>
</div>


