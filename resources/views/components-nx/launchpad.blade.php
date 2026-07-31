{{--
    nx-launchpad — Vollflächiger App-Launcher (Notion-Style).

    Ein ruhiger Fullscreen-Overlay mit Kachel-Raster aller Module des Users.
    Ausgelöst per Tastenkürzel (default ⌘/Strg + ⇧ + L) oder per Event
    `open-launchpad` (window). Suche filtert client-seitig; Enter öffnet den
    ersten Treffer. Esc / Klick daneben schließt. Das Kürzel toggelt.

    Aufbau (ohne Suche): Anker (neutral) · Favoriten · Alle Module (farbig).
    Bei Suche kollabiert alles zu einem flachen Treffer-Raster.

    <x-nx-launchpad :modules="$modules" :anchors="$anchors" :favorites="$favorites" />

    Props:
      modules   : Array von [ 'key','title','icon' (heroicon), 'url', 'group', 'badge'? ]
      anchors   : wie modules — strukturelle Einstiegspunkte (Home/Organisation),
                  NEUTRALE (Chrome) Reihe oben, per Hairline getrennt.
      favorites : wie modules — meistgenutzte Module (ModuleUsageCount). Farbig,
                  eigene Zeile unter den Ankern; bei Suche ausgeblendet.
      hotkey    : Buchstabe (kleingeschrieben) fürs Kürzel mit Meta/Strg+Shift
                  (default 'l' → ⌘/Strg + ⇧ + L)

    Programmatisch öffnen (z.B. aus einem Button):
      $dispatch('open-launchpad')  bzw.  window.dispatchEvent(new Event('open-launchpad'))
--}}
@props([
    'modules'   => [],
    'anchors'   => [],
    'favorites' => [],
    'hotkey'    => 'l',
])

@php
    // Gruppe bestimmt die Farbe — stabil & bedeutungstragend (nicht positionsabhängig).
    // Tints/Marken aus der --nx-tone-* Palette. Unbekannte Gruppe → slate.
    $groupTones = [
        'planning' => 'sky',
        'content'  => 'violet',
        'sales'    => 'amber',
        'finance'  => 'emerald',
        'hr'       => 'pink',
        'tools'    => 'teal',
        'admin'    => 'slate',
        'other'    => 'indigo',
    ];

    $labelClass = 'col-span-full px-1 text-[11px] font-semibold uppercase tracking-wide text-[color:var(--nx-faint)]';
@endphp

<div
    x-data="{
        open: false,
        search: '',
        noResults: false,
        hotkey: @js(strtolower($hotkey)),

        onKey(e) {
            if ((e.metaKey || e.ctrlKey) && e.shiftKey && e.key.toLowerCase() === this.hotkey) {
                e.preventDefault();
                this.open ? this.close() : this.openPad();
            }
        },
        openPad() {
            this.open = true;
            this.$nextTick(() => this.$refs.search?.focus());
        },
        close() { this.open = false; this.search = ''; },
    }"
    @keydown.window="onKey($event)"
    @keydown.escape.window="close()"
    @open-launchpad.window="openPad()"
>
    {{-- Overlay --}}
    <template x-teleport="body">
        <div x-show="open" x-cloak
            @click.self="close()"
            class="fixed inset-0 z-[95] flex flex-col items-center px-6 pb-6 pt-12"
            style="background: rgba(244,243,238,.72); backdrop-filter: blur(22px) saturate(1.1); -webkit-backdrop-filter: blur(22px) saturate(1.1);"
            x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            {{-- Suche --}}
            <div class="w-full max-w-[440px] shrink-0">
                <input x-ref="search" x-model="search" type="text" placeholder="Modul suchen …"
                    @keydown.enter.prevent="Array.from($refs.grid.querySelectorAll('a.lp-item')).find(a => a.offsetParent !== null)?.click()"
                    class="w-full rounded-[8px] border border-[color:var(--nx-line-strong)] bg-[color:var(--nx-surface)] px-4 py-2.5 text-[15px] text-[color:var(--nx-text)] placeholder-[color:var(--nx-faint)] shadow-[var(--nx-shadow-card)] focus:border-[color:var(--nx-accent)] focus:outline-none focus:ring-2 focus:ring-[color:var(--nx-accent-soft)]" />
            </div>

            {{-- Raster --}}
            <div x-ref="grid"
                x-effect="noResults = !!search && Array.from($refs.grid?.querySelectorAll('a.lp-item') || []).every(a => a.offsetParent === null)"
                class="mt-8 grid w-full min-h-0 max-w-[1120px] flex-1 grid-cols-3 gap-x-5 gap-y-8 overflow-y-auto sm:grid-cols-4 lg:grid-cols-7"
                style="align-content: safe center">

                {{-- Anker (neutral/Chrome) — strukturelle Einstiegspunkte, eigene Reihe oben --}}
                @foreach($anchors as $m)
                    @include('ui-tailwind::components-nx.launchpad._tile', ['m' => $m, 'groupTones' => $groupTones, 'neutral' => true])
                @endforeach
                @if(count($anchors))
                    <div x-show="!search" class="col-span-full h-px bg-[color:var(--nx-line)]"></div>
                @endif

                {{-- Favoriten (meistgenutzt) — farbig, nur ohne Suche --}}
                @if(count($favorites))
                    <div x-show="!search" class="{{ $labelClass }} -mb-2">Favoriten</div>
                    @foreach($favorites as $m)
                        @include('ui-tailwind::components-nx.launchpad._tile', ['m' => $m, 'groupTones' => $groupTones, 'show' => '!search'])
                    @endforeach
                    <div x-show="!search" class="{{ $labelClass }} -mb-2">Alle Module</div>
                @endif

                {{-- Alle Module (farbig nach Gruppe) --}}
                @forelse($modules as $m)
                    @include('ui-tailwind::components-nx.launchpad._tile', ['m' => $m, 'groupTones' => $groupTones])
                @empty
                    <div class="col-span-full py-10 text-center text-sm text-[color:var(--nx-muted)]">Keine Module verfügbar</div>
                @endforelse

                <div x-show="noResults" x-cloak class="col-span-full py-10 text-center text-sm text-[color:var(--nx-muted)]">
                    Kein Modul gefunden
                </div>
            </div>

            <div class="mt-auto pt-4 text-[12px] text-[color:var(--nx-faint)]">
                <span>⌘/Strg + ⇧ + {{ strtoupper($hotkey) }} öffnet · Esc schließt</span>
            </div>
        </div>
    </template>
</div>
