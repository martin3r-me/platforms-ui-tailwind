@props([
    'title' => '',
    'width' => 'w-80',         // expanded width
    'defaultOpen' => true,
    'storeKey' => 'sidebarOpen', // für Aktivitäten explizit "activityOpen" setzen
    'side' => 'left',            // 'left' | 'right'
    'icon' => null,              // optionaler Heroicon-Name fürs Rail (z.B. heroicon-o-bolt)
    'railWidth' => 'w-11',       // collapsed rail width (~44px)
])

@php
    $openExpr = "(Alpine?.store('page')?.['{$storeKey}'] ?? " . ($defaultOpen ? 'true' : 'false') . ")";
    $borderClass = $side === 'right' ? 'border-l border-[var(--ui-border)]/60' : 'border-r border-[var(--ui-border)]/60';
    $expandIcon = $side === 'right' ? 'heroicon-o-chevron-double-left' : 'heroicon-o-chevron-double-right';
@endphp

<div
    x-data
    :class="{{ $openExpr }} ? '{{ $width }}' : '{{ $railWidth }}'"
    class="relative flex-shrink-0 h-full bg-[var(--ui-muted-5)] transition-all duration-300 overflow-x-hidden {{ $borderClass }}"
    {{ $attributes }}
>
    {{-- Collapsed Rail — bleibt immer sichtbar, gleicher Mechanismus wie Done/Dashboard-Strips --}}
    <button
        type="button"
        x-show="!{{ $openExpr }}"
        x-cloak
        @click="Alpine?.store('page') && (Alpine.store('page')['{{ $storeKey }}'] = true)"
        class="group/rail h-full w-full flex flex-col items-center justify-between py-3 px-2 hover:bg-[var(--ui-muted-10)] transition-colors cursor-pointer"
        title="@if($title){{ $title }} öffnen @else Öffnen @endif"
    >
        {{-- Top: Icon-Chip oder Expand-Chevron --}}
        @if($icon)
            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-white shadow-sm flex-shrink-0">
                @svg($icon, 'w-3.5 h-3.5 text-[var(--ui-secondary)]')
            </span>
        @else
            @svg($expandIcon, 'w-4 h-4 text-[var(--ui-muted)] group-hover/rail:text-[var(--ui-secondary)] transition-colors flex-shrink-0')
        @endif

        {{-- Middle: vertikales Titel-Label --}}
        @if($title)
            <span
                class="text-[10px] font-semibold uppercase tracking-wider text-[var(--ui-muted)] group-hover/rail:text-[var(--ui-secondary)] transition-colors my-2 truncate"
                style="writing-mode: vertical-rl; transform: rotate(180deg); max-height: 100%;"
            >
                {{ $title }}
            </span>
        @else
            <span class="flex-1"></span>
        @endif

        {{-- Bottom: Expand-Chevron (wenn oben schon das Icon ist) --}}
        @if($icon)
            @svg($expandIcon, 'w-4 h-4 text-[var(--ui-muted)] group-hover/rail:text-[var(--ui-secondary)] transition-colors flex-shrink-0')
        @else
            <span class="block w-1.5 h-1.5"></span>
        @endif
    </button>

    {{-- Expanded Content --}}
    <div
        x-show="{{ $openExpr }}"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="h-full overflow-hidden overflow-x-hidden flex flex-col"
    >
        @if($title)
            <div class="px-6 h-14 flex-shrink-0 flex items-center border-b border-[var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur">
                @if($icon)
                    <span class="inline-flex items-center justify-center w-5 h-5 mr-2 text-[var(--ui-secondary)]">
                        @svg($icon, 'w-4 h-4')
                    </span>
                @endif
                <h2 class="text-sm font-semibold text-[var(--ui-secondary)] m-0 tracking-wide uppercase truncate">{{ $title }}</h2>
                <button
                    type="button"
                    @click="Alpine?.store('page') && (Alpine.store('page')['{{ $storeKey }}'] = false)"
                    class="ml-auto inline-flex items-center justify-center w-7 h-7 rounded-md text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors flex-shrink-0"
                    title="Einklappen"
                >
                    @svg('heroicon-o-chevron-double-left', 'w-4 h-4', ['class' => $side === 'right' ? 'rotate-180' : ''])
                </button>
            </div>
        @endif

        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            {{ $slot }}
        </div>
    </div>
</div>
