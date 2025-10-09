@props([
    'title' => '',
    'icon' => null,
])

<div class="sticky top-0 z-10 px-4 h-14 bg-[var(--ui-surface)]/90 border-b border-[var(--ui-border)]/60 backdrop-blur">
    <div class="h-full flex items-center justify-between gap-3">
        {{-- Links: Titel --}}
        <div class="flex items-center gap-3 min-w-0">
            @if($icon)
                @svg($icon, 'w-6 h-6 flex-shrink-0 text-[color:var(--ui-primary)]')
            @endif
            <h1 class="m-0 truncate text-[color:var(--ui-secondary)] font-semibold tracking-tight text-base md:text-lg">
                {{ $title }}
            </h1>
        </div>

        {{-- Rechts: Aktionen + Sidebar-Toggles --}}
        <div class="flex items-center gap-2">
            {{ $slot }}
            <div class="h-8 w-px bg-[var(--ui-border)]/60 mx-1"></div>
            <div class="flex items-center gap-1">
                {{-- Left Sidebar Toggle --}}
                <button x-data @click="Alpine.store('page') && (Alpine.store('page').sidebarOpen = !Alpine.store('page').sidebarOpen)" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition" title="Linke Sidebar umschalten">
                    {{-- Icon: zwei vertikale Panels, links akzent --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <rect x="3" y="5" width="8" height="14" rx="2" class="opacity-90" />
                        <rect x="11" y="5" width="10" height="14" rx="2" class="opacity-40" />
                    </svg>
                </button>
                {{-- Right Activity Sidebar Toggle --}}
                <button x-data @click="Alpine.store('page') && (Alpine.store('page').activityOpen = !Alpine.store('page').activityOpen)" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition" title="Aktivitäten-Sidebar umschalten">
                    {{-- Icon: zwei vertikale Panels, rechts akzent --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <rect x="3" y="5" width="10" height="14" rx="2" class="opacity-40" />
                        <rect x="13" y="5" width="8" height="14" rx="2" class="opacity-90" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

