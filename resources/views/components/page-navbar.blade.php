@props([
    'title' => '',
    'icon' => null,
    'team' => null, // Optional: String oder Objekt mit name-Eigenschaft; wenn null, wird currentTeam genutzt
])

@php
    $__teamName = is_string($team)
        ? $team
        : ($team->name ?? (auth()->user()?->currentTeam?->name ?? null));
@endphp

<div class="sticky top-0 z-10 px-4 h-14 bg-[var(--ui-surface)]/90 border-b border-[var(--ui-border)]/60 backdrop-blur">
    <div class="h-full flex items-center justify-between gap-3">
        {{-- Links: Titel + Left Sidebar Toggle --}}
        <div class="flex items-center gap-3 min-w-0">
            {{-- Left Sidebar Toggle --}}
            <button x-data 
                @click="Alpine.store('page') && (Alpine.store('page').sidebarOpen = !Alpine.store('page').sidebarOpen)"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition"
                :class="Alpine.store('page')?.sidebarOpen 
                    ? 'text-[var(--ui-primary)] bg-[var(--ui-muted-5)]' 
                    : 'text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]'"
                title="Linke Sidebar umschalten">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <rect x="3" y="5" width="8" height="14" rx="2" class="opacity-90" />
                    <rect x="11" y="5" width="10" height="14" rx="2" class="opacity-40" />
                </svg>
            </button>
            @if($icon)
                @svg($icon, 'w-6 h-6 flex-shrink-0 text-[color:var(--ui-primary)]')
            @endif
            <h1 class="m-0 truncate text-[color:var(--ui-secondary)] font-semibold tracking-tight text-base md:text-lg">
                {{ $title }}
            </h1>
            @if($__teamName)
                <button type="button"
                    @click="$dispatch('open-modal-team')"
                    class="inline-flex items-center gap-1 max-w-[16rem] ml-1 px-2 h-6 rounded-full border border-[var(--ui-border)]/60 bg-[var(--ui-muted-5)] text-[color:var(--ui-muted)] text-xs hover:text-[color:var(--ui-primary)] hover:border-[var(--ui-primary)]/60 transition-colors"
                    title="Team wechseln">
                    <span class="truncate" title="{{ $__teamName }}">
                        {{ $__teamName }}
                    </span>
                </button>
            @endif
            @isset($titleActions)
                <div class="flex items-center gap-2 ml-2">
                    {{ $titleActions }}
                </div>
            @endisset
        </div>

        {{-- Rechts: Aktionen + Sidebar-Toggles --}}
        <div class="flex items-center gap-2">
            {{ $slot }}
            
            {{-- Quick Triggers: Team, User, Check-in --}}
            <button x-data
                @click="$dispatch('open-modal-team')"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]"
                title="Team verwalten">
                @svg('heroicon-o-users', 'w-5 h-5')
            </button>
            <button x-data
                @click="$dispatch('open-modal-user')"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]"
                title="Benutzer-Einstellungen">
                @svg('heroicon-o-user', 'w-5 h-5')
            </button>
            <button x-data
                @click="$dispatch('open-modal-checkin')"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]"
                title="Täglicher Check-in">
                @svg('heroicon-o-flag', 'w-5 h-5')
            </button>

            <div class="h-8 w-px bg-[var(--ui-border)]/60 mx-1"></div>
            {{-- Terminal Toggle (adjacent to Activity Toggle) --}}
            <button x-data
                @click="window.dispatchEvent(new CustomEvent('toggle-terminal'))"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition"
                :class="Alpine.store('page')?.terminalOpen 
                    ? 'text-[var(--ui-primary)] bg-[var(--ui-muted-5)]' 
                    : 'text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]'"
                title="Terminal umschalten">
                @svg('heroicon-o-command-line', 'w-5 h-5')
            </button>
            {{-- Right Activity Sidebar Toggle --}}
            <button x-data 
                @click="Alpine.store('page') && (Alpine.store('page').activityOpen = !Alpine.store('page').activityOpen)" 
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition"
                :class="Alpine.store('page')?.activityOpen 
                    ? 'text-[var(--ui-primary)] bg-[var(--ui-muted-5)]' 
                    : 'text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]'"
                title="Aktivitäten-Sidebar umschalten">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <rect x="3" y="5" width="10" height="14" rx="2" class="opacity-40" />
                    <rect x="13" y="5" width="8" height="14" rx="2" class="opacity-90" />
                </svg>
            </button>
        </div>
    </div>
</div>

