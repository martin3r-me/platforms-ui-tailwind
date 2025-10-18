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
            
            {{-- Combined Team & Module Flyout --}}
            <div x-data="{ combinedFlyoutOpen: false }" 
                 @open-team-flyout.window="combinedFlyoutOpen = true"
                 @open-module-flyout.window="combinedFlyoutOpen = true"
                 @click.away="combinedFlyoutOpen = false"
                 class="relative hidden sm:block">
                
                <button @click="combinedFlyoutOpen = !combinedFlyoutOpen" 
                    class="inline-flex items-center gap-1 px-2 py-1 h-7 rounded-md border transition text-xs
                    text-[var(--ui-primary)] bg-[var(--ui-primary-5)] border-[var(--ui-primary)]/60"
                    title="Team & Module wechseln">
                    <span class="truncate max-w-[12rem]">{{ $__teamName ?? 'Team' }}</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="combinedFlyoutOpen" x-cloak x-transition
                    class="absolute top-full left-0 mt-2 w-screen max-w-4xl bg-[var(--ui-surface)] rounded-2xl border border-[var(--ui-border)]/60 shadow-lg z-50">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                            {{-- Modules Section (Links) --}}
                            <div>
                                <h3 class="text-sm font-semibold text-[var(--ui-muted)] mb-4">Verfügbare Module</h3>
                                <div class="space-y-3">
                                    {{-- Dashboard --}}
                                    <a href="{{ route('platform.dashboard') }}"
                                        class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-[var(--ui-muted-5)] transition">
                                        <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-[var(--ui-primary-5)] group-hover:bg-[var(--ui-primary-10)]">
                                            @svg('heroicon-o-home', 'w-6 h-6 text-[var(--ui-primary)]')
                                        </div>
                                        <div>
                                            <div class="font-semibold text-[var(--ui-secondary)]">Haupt-Dashboard</div>
                                            <p class="mt-1 text-sm text-[var(--ui-muted)]">Übersicht & Start</p>
                                        </div>
                                    </a>

                                    @php
                                        $user = auth()->user();
                                        $team = method_exists($user, 'currentTeam') ? $user->currentTeam : null;
                                        $teamId = $team?->id;
                                        $modules = \Platform\Core\PlatformCore::getVisibleModules();
                                        $filteredModules = collect($modules)->filter(function($module) use ($user, $team, $teamId) {
                                            $moduleModel = \Platform\Core\Models\Module::where('key', $module['key'])->first();
                                            if (!$moduleModel) return false;
                                            $userAllowed = $user->modules()->where('module_id', $moduleModel->id)->wherePivot('team_id', $teamId)->wherePivot('enabled', true)->exists();
                                            $teamAllowed = $team ? $team->modules()->where('module_id', $moduleModel->id)->wherePivot('enabled', true)->exists() : false;
                                            return $userAllowed || $teamAllowed;
                                        })->take(4)->values();
                                    @endphp

                                    @foreach($filteredModules as $key => $module)
                                        @php
                                            $title = $module['title'] ?? $module['label'] ?? ucfirst($key);
                                            $description = $module['description'] ?? 'Ein leistungsstarkes Tool für Ihr Team.';
                                            $icon = $module['navigation']['icon'] ?? ($module['icon'] ?? null);
                                            $routeName = $module['navigation']['route'] ?? null;
                                            $finalUrl = $routeName && \Illuminate\Support\Facades\Route::has($routeName) ? route($routeName) : ($module['url'] ?? '#');
                                        @endphp
                                        <a href="{{ $finalUrl }}"
                                            class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-[var(--ui-muted-5)] transition">
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-[var(--ui-primary-5)] group-hover:bg-[var(--ui-primary-10)]">
                                                @if(!empty($icon))
                                                    <x-dynamic-component :component="$icon" class="w-6 h-6 text-[var(--ui-primary)]" />
                                                @else
                                                    @svg('heroicon-o-cube', 'w-6 h-6 text-[var(--ui-primary)]')
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-semibold text-[var(--ui-secondary)]">{{ $title }}</div>
                                                <p class="mt-1 text-sm text-[var(--ui-muted)]">{{ $description }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Teams Section (Rechts) --}}
                            <div>
                                <h3 class="text-sm font-semibold text-[var(--ui-muted)] mb-4">Ihre Teams</h3>
                                <div class="space-y-3">
                                    @php
                                        $userTeams = auth()->user()?->teams()->take(4)->get() ?? collect();
                                        $currentTeam = auth()->user()?->currentTeam;
                                    @endphp
                                    @foreach($userTeams as $team)
                                        @php $isActiveTeam = $currentTeam?->id === $team->id; @endphp
                                        <button type="button" @click="$dispatch('open-modal-modules', { tab: 'teams' }); combinedFlyoutOpen = false"
                                            class="group relative flex gap-x-6 rounded-lg p-4 hover:bg-[var(--ui-muted-5)] transition w-full text-left
                                            {{ $isActiveTeam ? 'bg-[var(--ui-primary-5)] border border-[var(--ui-primary)]/60' : '' }}">
                                            <div class="mt-1 flex size-11 flex-none items-center justify-center rounded-lg bg-[var(--ui-primary-5)] group-hover:bg-[var(--ui-primary-10)]">
                                                @svg('heroicon-o-user-group', 'w-6 h-6 text-[var(--ui-primary)]')
                                            </div>
                                            <div class="flex-1">
                                                <div class="font-semibold text-[var(--ui-secondary)]">{{ $team->name }}</div>
                                                <p class="mt-1 text-sm text-[var(--ui-muted)]">
                                                    @if($team->users()->count() > 0)
                                                        {{ $team->users()->count() }} Mitglieder
                                                    @else
                                                        Team verwalten
                                                    @endif
                                                </p>
                                            </div>
                                            @if($isActiveTeam)
                                                <div class="flex-shrink-0 mt-1">
                                                    @svg('heroicon-o-check', 'w-5 h-5 text-[var(--ui-primary)]')
                                                </div>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        {{-- Footer wie im Beispiel --}}
                        <div class="mt-6 bg-[var(--ui-muted-5)] px-6 py-4 rounded-lg">
                            <div class="flex items-center gap-x-3">
                                <h3 class="text-sm font-semibold text-[var(--ui-secondary)]">Alle Teams & Module</h3>
                                <span class="rounded-full bg-[var(--ui-primary-5)] px-2.5 py-1.5 text-xs font-semibold text-[var(--ui-primary)]">Neu</span>
                            </div>
                            <p class="mt-2 text-sm text-[var(--ui-muted)]">Verwalten Sie alle Teams und Module an einem Ort.</p>
                            <button type="button" @click="$dispatch('open-modal-modules', { tab: 'modules' }); combinedFlyoutOpen = false" 
                                class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-[var(--ui-primary)] hover:text-[var(--ui-primary)] transition">
                                Alle anzeigen
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

