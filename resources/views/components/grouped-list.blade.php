@props([
    'title' => null,
    'icon' => null,
])

@php
    $uid = \Illuminate\Support\Str::uuid()->toString();
@endphp

<div x-data="{ open: false }">
    <button 
        type="button"
        class="w-full flex items-center justify-between py-2 px-1 text-[color:var(--ui-info)] text-xs font-semibold tracking-wide uppercase rounded hover:bg-[color:var(--ui-info-10)] transition-colors"
        @click="open = !open"
        aria-controls="group-{{ $uid }}"
        :aria-expanded="open.toString()"
    >
        <span class="flex items-center gap-1">
            @if($icon)
                @svg($icon, 'w-4 h-4 text-[color:var(--ui-info)]')
            @endif
            {{ $title }}
        </span>
        <span class="transition-transform duration-200" :class="{ 'rotate-90': open }">
            @svg('heroicon-o-chevron-right', 'w-4 h-4 text-[color:var(--ui-info)]')
        </span>
    </button>

    <ul 
        x-show="open"
        x-collapse
        id="group-{{ $uid }}"
        class="space-y-1 mt-1"
    >
        {{ $slot }}
    </ul>
</div>