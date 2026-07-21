@props([
    'label' => null,
])

<div x-show="!collapsed" class="px-2 py-2 border-b border-[color:var(--nx-line)]">
    @if($label)
        <div class="px-1 pb-2 text-xs font-medium tracking-wide text-[color:var(--nx-faint)]">{{ $label }}</div>
    @endif
    <div class="flex flex-col gap-1">
        {{ $slot }}
    </div>
</div>


