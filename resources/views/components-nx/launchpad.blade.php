{{--
    nx-launchpad — Vollflächiger App-Launcher (Notion-Style).

    Ein ruhiger Fullscreen-Overlay mit Kachel-Raster aller Module des Users,
    ausgelöst per Hot-Corner (Maus in eine Bildschirmecke, kurz halten) oder
    per Event `open-launchpad` (window). Suche filtert client-seitig; Enter
    öffnet den ersten Treffer. Esc / Klick daneben schließt.

    <x-nx-launchpad :modules="$modules" />

    Props:
      modules : Array von [ 'key','title','icon' (heroicon-Component), 'url', 'badge'? ]
      corners : aktive Ecken — Teilmenge von
                ['top-left','top-right','bottom-left','bottom-right'] (default: bottom-left)
      dwell   : Verweildauer in ms, bis eine Ecke auslöst (default 380)

    Programmatisch öffnen (z.B. aus einem Button):
      $dispatch('open-launchpad')  bzw.  window.dispatchEvent(new Event('open-launchpad'))
--}}
@props([
    'modules' => [],
    'corners' => ['bottom-left'],
    'dwell'   => 380,
])

@php
    // Dezente Notion-Tints aus der --nx-tone-* Palette, deterministisch pro Kachel.
    $tones = ['rose', 'amber', 'emerald', 'teal', 'sky', 'indigo', 'violet', 'pink', 'slate'];
@endphp

<div
    x-data="{
        open: false,
        search: '',
        arming: null,
        noResults: false,
        corners: @js(array_values($corners)),
        dwell: {{ (int) $dwell }},
        threshold: 6,
        _timer: null,

        cornerAt(x, y) {
            const w = window.innerWidth, h = window.innerHeight, t = this.threshold;
            if (y <= t && x <= t) return 'top-left';
            if (y <= t && x >= w - t) return 'top-right';
            if (y >= h - t && x <= t) return 'bottom-left';
            if (y >= h - t && x >= w - t) return 'bottom-right';
            return null;
        },
        onMove(e) {
            if (this.open) return;
            const c = this.cornerAt(e.clientX, e.clientY);
            if (c && this.corners.includes(c)) {
                if (this.arming !== c) {
                    this.arming = c;
                    clearTimeout(this._timer);
                    this._timer = setTimeout(() => this.openPad(), this.dwell);
                }
            } else if (this.arming) {
                this.arming = null;
                clearTimeout(this._timer);
            }
        },
        openPad() {
            this.arming = null;
            clearTimeout(this._timer);
            this.open = true;
            this.$nextTick(() => this.$refs.search?.focus());
        },
        close() { this.open = false; this.search = ''; },
    }"
    @mousemove.window="onMove($event)"
    @keydown.escape.window="close()"
    @open-launchpad.window="openPad()"
>
    {{-- Hot-Corner-Indikator (füllt sich während des Verweilens) --}}
    <div x-show="arming" x-cloak
        class="pointer-events-none fixed z-[94] h-11 w-11 rounded-[12px] border-2 border-[color:var(--nx-accent)]"
        style="background: var(--nx-accent-soft)"
        :class="{
            'top-3 left-3': arming === 'top-left',
            'top-3 right-3': arming === 'top-right',
            'bottom-3 left-3': arming === 'bottom-left',
            'bottom-3 right-3': arming === 'bottom-right',
        }"
        x-transition:enter="ease-out duration-150" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"></div>

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

            {{-- Kachel-Raster --}}
            <div x-ref="grid"
                x-effect="noResults = !!search && Array.from($refs.grid?.querySelectorAll('a.lp-item') || []).every(a => a.offsetParent === null)"
                class="mt-8 grid w-full min-h-0 max-w-[1120px] flex-1 grid-cols-3 gap-x-5 gap-y-8 overflow-y-auto sm:grid-cols-4 lg:grid-cols-7"
                style="align-content: safe center">

                @forelse($modules as $m)
                    @php
                        $title = $m['title'] ?? ucfirst($m['key'] ?? '');
                        $icon  = $m['icon'] ?? null;
                        if ($icon && ! \Illuminate\Support\Str::startsWith($icon, 'heroicon')) {
                            $icon = 'heroicon-o-' . $icon;
                        }
                        $url   = $m['url'] ?? '#';
                        $badge = $m['badge'] ?? null;
                        $tone  = $tones[$loop->index % count($tones)];
                        $tint  = "color-mix(in srgb, var(--nx-tone-{$tone}) 16%, #ffffff)";
                    @endphp
                    <a href="{{ $url }}"
                        data-title="{{ \Illuminate\Support\Str::lower($title) }}"
                        x-show="!search || $el.dataset.title.includes(search.toLowerCase())"
                        @click="close()"
                        class="lp-item group flex flex-col items-center gap-2 rounded-[12px] p-2.5 transition-colors hover:bg-[color:var(--nx-hover)]">
                        <span class="relative grid h-[60px] w-[60px] place-items-center rounded-[14px] border border-[color:var(--nx-line)] text-[color:var(--nx-text)] shadow-[var(--nx-shadow-card)] transition-transform duration-150 group-hover:-translate-y-0.5"
                            style="background: {{ $tint }}">
                            @if($icon)
                                <x-dynamic-component :component="$icon" class="h-7 w-7" />
                            @else
                                @svg('heroicon-o-cube', 'w-7 h-7')
                            @endif
                            @if($badge)
                                <span class="absolute -right-1.5 -top-1.5 grid h-5 min-w-[20px] place-items-center rounded-full border-2 border-[color:var(--nx-bg)] bg-[color:var(--nx-danger)] px-1.5 text-[11px] font-semibold text-white">{{ $badge > 99 ? '99+' : $badge }}</span>
                            @endif
                        </span>
                        <span class="max-w-[92px] text-center text-[13px] font-medium leading-tight text-[color:var(--nx-text)]">{{ $title }}</span>
                    </a>
                @empty
                    <div class="col-span-full py-10 text-center text-sm text-[color:var(--nx-muted)]">Keine Module verfügbar</div>
                @endforelse

                <div x-show="noResults" x-cloak class="col-span-full py-10 text-center text-sm text-[color:var(--nx-muted)]">
                    Kein Modul gefunden
                </div>
            </div>

            <div class="mt-auto pt-4 text-[12px] text-[color:var(--nx-faint)]">
                <span>Esc zum Schließen</span>
            </div>
        </div>
    </template>
</div>
