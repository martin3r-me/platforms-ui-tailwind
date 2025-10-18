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
            <h1 class="m-0 truncate text-[color:var(--ui-secondary)] font-semibold tracking-tight text-base md:text-lg">
                {{ $title }}
            </h1>
            @isset($titleActions)
                <div class="flex items-center gap-2 ml-2">
                    {{ $titleActions }}
                </div>
            @endisset
        </div>

        {{-- Rechts: Aktionen + Sidebar-Toggles --}}
        <div class="flex items-center gap-2">
            {{ $slot }}
            
            @php 
                $__teamNameInline = auth()->user()?->currentTeam?->name ?? null; 
                $__moduleNameInline = ucfirst(request()->segment(1) ?? 'dashboard');
                $userTeams = auth()->user()?->teams()->take(4)->get() ?? collect();
                $availableModules = $modules ?? [];
            @endphp

            {{-- Team Flyout --}}
            <div class="relative hidden sm:block">
                <button x-data="{ open: false }" 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="inline-flex items-center gap-1 px-3 py-1.5 h-8 rounded-md border transition
                    text-[var(--ui-primary)] bg-[var(--ui-primary-5)] border-[var(--ui-primary)]/60
                    hover:text-[var(--ui-muted)] hover:bg-transparent hover:border-[var(--ui-border)]/60"
                    title="Team wechseln">
                    <span class="truncate max-w-[8rem]">{{ $__teamNameInline ?? 'Team' }}</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="open" x-cloak x-transition
                    class="absolute top-full left-0 mt-2 w-80 bg-[var(--ui-surface)] rounded-xl border border-[var(--ui-border)]/60 shadow-lg z-50">
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-[var(--ui-muted)] mb-3">Teams</h3>
                        <div class="space-y-2">
                            @foreach($userTeams as $team)
                                @php $isActiveTeam = auth()->user()?->currentTeam?->id === $team->id; @endphp
                                <button type="button" wire:click="switchTeam({{ $team->id }})"
                                    class="w-full group flex items-center gap-3 p-3 rounded-lg transition
                                    {{ $isActiveTeam ? 'bg-[var(--ui-primary-5)] border border-[var(--ui-primary)]/60' : 'hover:bg-[var(--ui-muted-5)]' }}">
                                    <div class="flex-shrink-0">
                                        @svg('heroicon-o-user-group', 'w-5 h-5 text-[var(--ui-primary)]')
                                    </div>
                                    <div class="min-w-0 flex-1 text-left">
                                        <div class="font-medium text-[var(--ui-secondary)] truncate">{{ $team->name }}</div>
                                        @if($team->users()->count() > 0)
                                            <div class="text-xs text-[var(--ui-muted)]">{{ $team->users()->count() }} Mitglieder</div>
                                        @endif
                                    </div>
                                    @if($isActiveTeam)
                                        <div class="flex-shrink-0">
                                            @svg('heroicon-o-check', 'w-4 h-4 text-[var(--ui-primary)]')
                                        </div>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                        <div class="mt-3 pt-3 border-t border-[var(--ui-border)]/60">
                            <button type="button" @click="$dispatch('open-modal-modules')" 
                                class="w-full flex items-center justify-center gap-2 p-2 text-sm font-medium text-[var(--ui-muted)] hover:text-[var(--ui-primary)] transition">
                                Alle Teams anzeigen
                                @svg('heroicon-o-arrow-right', 'w-4 h-4')
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Module Flyout --}}
            <div class="relative hidden sm:block">
                <button x-data="{ open: false }" 
                    @click="open = !open" 
                    @click.away="open = false"
                    class="inline-flex items-center gap-1 px-3 py-1.5 h-8 rounded-md border transition
                    text-[var(--ui-primary)] bg-[var(--ui-primary-5)] border-[var(--ui-primary)]/60
                    hover:text-[var(--ui-muted)] hover:bg-transparent hover:border-[var(--ui-border)]/60"
                    title="Modul wechseln">
                    <span class="truncate max-w-[8rem]">{{ $__moduleNameInline }}</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="open" x-cloak x-transition
                    class="absolute top-full left-0 mt-2 w-80 bg-[var(--ui-surface)] rounded-xl border border-[var(--ui-border)]/60 shadow-lg z-50">
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-[var(--ui-muted)] mb-3">Module</h3>
                        <div class="space-y-2">
                            {{-- Dashboard --}}
                            <a href="{{ route('platform.dashboard') }}"
                                class="w-full group flex items-center gap-3 p-3 rounded-lg transition hover:bg-[var(--ui-muted-5)]">
                                <div class="flex-shrink-0">
                                    @svg('heroicon-o-home', 'w-5 h-5 text-[var(--ui-primary)]')
                                </div>
                                <div class="min-w-0 flex-1 text-left">
                                    <div class="font-medium text-[var(--ui-secondary)]">Haupt-Dashboard</div>
                                    <div class="text-xs text-[var(--ui-muted)]">Übersicht & Start</div>
                                </div>
                                @svg('heroicon-o-arrow-right', 'w-4 h-4 text-[var(--ui-muted)] group-hover:text-[var(--ui-primary)]')
                            </a>

                            @foreach($availableModules as $key => $module)
                                @php
                                    $title = $module['title'] ?? $module['label'] ?? ucfirst($key);
                                    $icon = $module['navigation']['icon'] ?? ($module['icon'] ?? null);
                                    $routeName = $module['navigation']['route'] ?? null;
                                    $finalUrl = $routeName && \Illuminate\Support\Facades\Route::has($routeName)
                                        ? route($routeName)
                                        : ($module['url'] ?? '#');
                                @endphp
                                <a href="{{ $finalUrl }}"
                                    class="w-full group flex items-center gap-3 p-3 rounded-lg transition hover:bg-[var(--ui-muted-5)]">
                                    <div class="flex-shrink-0">
                                        @if(!empty($icon))
                                            <x-dynamic-component :component="$icon" class="w-5 h-5 text-[var(--ui-primary)]" />
                                        @else
                                            @svg('heroicon-o-cube', 'w-5 h-5 text-[var(--ui-primary)]')
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1 text-left">
                                        <div class="font-medium text-[var(--ui-secondary)]">{{ $title }}</div>
                                        <div class="text-xs text-[var(--ui-muted)]">{{ $module['description'] ?? 'Modul' }}</div>
                                    </div>
                                    @svg('heroicon-o-arrow-right', 'w-4 h-4 text-[var(--ui-muted)] group-hover:text-[var(--ui-primary)]')
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-3 pt-3 border-t border-[var(--ui-border)]/60">
                            <button type="button" @click="$dispatch('open-modal-modules')" 
                                class="w-full flex items-center justify-center gap-2 p-2 text-sm font-medium text-[var(--ui-muted)] hover:text-[var(--ui-primary)] transition">
                                Alle Module anzeigen
                                @svg('heroicon-o-arrow-right', 'w-4 h-4')
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Triggers: Team, User, Check-in --}}
            <button x-data
                @click="$dispatch('open-modal-comms')"
                class="inline-flex items-center justify-center w-8 h-8 rounded-md border border-[var(--ui-border)]/60 transition text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]"
                title="Comms">
                @svg('heroicon-o-paper-airplane', 'w-5 h-5')
            </button>
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
                @svg('heroicon-o-bell-alert','w-5 h-5')
            </button>
        </div>
    </div>
</div>

