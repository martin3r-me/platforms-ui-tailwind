@props([
    'title' => null,
    'icon' => null,
])

@php
    $uid = \Illuminate\Support\Str::uuid()->toString();
@endphp

<div x-data="{ open: false }" class="grouped-list">
    <button 
        type="button"
        class="w-full d-flex items-center justify-between py-2 px-1
               text-info text-xs font-semibold tracking-wide uppercase
               rounded hover:bg-info-10 transition-colors"
        @click="open = !open"
        aria-controls="group-{{ $uid }}"
        :aria-expanded="open.toString()"
    >
        <span class="d-flex items-center gap-1">
            @if($icon)
                @svg($icon, 'w-4 h-4 text-info')
            @endif
            {{ $title }}
        </span>
        <span class="transition-transform duration-200" :class="{ 'rotate-90': open }">
            @svg('heroicon-o-chevron-right', 'w-4 h-4 text-info')
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