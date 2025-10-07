@props([
    'title' => '',
    'icon' => null,
])

<div class="sticky top-0 z-10 px-4 h-14 bg-[var(--ui-surface)]/90 border-b border-[var(--ui-border)]/60 backdrop-blur">
    <div class="h-full flex items-center justify-between gap-3">
        {{-- Links: Sidebar Toggle + Titel --}}
        <div class="flex items-center gap-3 min-w-0">
            <button x-data @click="Alpine.store('page') && (Alpine.store('page').sidebarOpen = !Alpine.store('page').sidebarOpen)" class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition" title="Sidebar umschalten">
                @svg('heroicon-o-bars-3','w-5 h-5')
            </button>
            @if($icon)
                @svg($icon, 'w-6 h-6 flex-shrink-0 text-[color:var(--ui-primary)]')
            @endif
            <h1 class="m-0 truncate text-[color:var(--ui-secondary)] font-semibold tracking-tight text-base md:text-lg">
                {{ $title }}
            </h1>
        </div>
        
        {{-- Aktionen-Bereich (rechts) --}}
        <div class="d-flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</div>

