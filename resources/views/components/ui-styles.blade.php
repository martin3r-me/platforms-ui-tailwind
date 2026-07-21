<style>
:root {
    /* ===== Farben & on-Color (auto aus config/ui.php) ===== */
    @foreach(config('ui.colors') as $key => $c)
        --ui-{{ $key }}-rgb: {{ $c['rgb'] }};
        --ui-{{ $key }}: rgb(var(--ui-{{ $key }}-rgb));
        --ui-on-{{ $key }}: {{ $c['on'] }};
        --ui-{{ $key }}-5:   rgba(var(--ui-{{ $key }}-rgb), 0.05);
        --ui-{{ $key }}-10:  rgba(var(--ui-{{ $key }}-rgb), 0.10);
        --ui-{{ $key }}-20:  rgba(var(--ui-{{ $key }}-rgb), 0.20);
        --ui-{{ $key }}-50:  rgba(var(--ui-{{ $key }}-rgb), 0.50);
        --ui-{{ $key }}-60:  rgba(var(--ui-{{ $key }}-rgb), 0.60);
        --ui-{{ $key }}-80:  rgba(var(--ui-{{ $key }}-rgb), 0.80);
        --ui-{{ $key }}-90:  rgba(var(--ui-{{ $key }}-rgb), 0.90);
    @endforeach

    /* ===== Body, Surface, Border (optional overridebar) ===== */
    --ui-body-bg:    {{ config('ui.body.bg') }};
    --ui-body-color: {{ config('ui.body.color') }};
    --ui-surface:    {{ config('ui.surface.bg', 'rgba(255,255,255,0.72)') }};
    --ui-surface-color: {{ config('ui.surface.color', '#1F2937') }};
    --ui-border:     {{ config('ui.border.color', 'rgba(0,0,0,.08)') }};

    /* ===== Spacing Scale ===== */
    @foreach(config('ui.spacing') as $key => $val)
        --ui-space-{{ $key }}: {{ $val }};
    @endforeach

    /* ===== Radius ===== */
    @foreach(config('ui.radius') as $key => $val)
        --ui-radius-{{ $key }}: {{ $val }};
    @endforeach

    /* ===== Breakpoints ===== */
    @foreach(config('ui.breakpoints') as $key => $val)
        --ui-break-{{ $key }}: {{ $val }};
    @endforeach

    /* ===== Glass & Shadows ===== */
    --ui-surface-solid: #fff;
    --ui-glass-blur: 12px;
    --ui-glass-border: rgba(255,255,255,0.5);
    --ui-shadow-xs: 0 1px 2px rgba(0,0,0,0.03);
    --ui-shadow-sm: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.03);
    --ui-shadow-md: 0 4px 12px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04);
    --ui-shadow-lg: 0 12px 32px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);

    /* ===== Typography ===== */
    --ui-font-sans: {{ config('ui.typography.font_sans') }};
    --ui-font-mono: {{ config('ui.typography.font_mono') }};
    @if(isset(config('ui.typography.size')['md']))
        --ui-text-md: {{ config('ui.typography.size.md') }};
    @endif
    /* Weitere Sizes/Weights/Leading bei Bedarf */

    /* =======================================================================
       nx — festes Notion-Design-System (env-UNABHÄNGIG, plattform-übergleich).
       Bewusst NICHT aus config/ui.php/.env — "die Plattform sieht immer gleich
       aus". Wird von den restylten Rahmen-Elementen und den x-nx-Bausteinen
       genutzt. Akzent = neutral Near-Black.
       ======================================================================= */
    --nx-bg:            #faf9f7;               /* warmes Off-White (Chrome/Seite) */
    --nx-surface:       #ffffff;               /* Karten/Flächen                  */
    --nx-elevated:      #ffffff;               /* Overlays/Popover                */
    --nx-text:          #37352f;               /* warmes Near-Black (Primärtext)  */
    --nx-muted:         #787774;               /* Sekundärtext                    */
    --nx-faint:         #9b9a97;               /* Meta/Captions                   */
    --nx-line:          rgba(55,53,47,.09);    /* Hairline statt Rahmen           */
    --nx-line-strong:   rgba(55,53,47,.16);
    --nx-hover:         rgba(55,53,47,.055);   /* dezente Hover-Fläche            */
    --nx-active:        rgba(55,53,47,.09);
    --nx-accent:        #37352f;               /* Akzent = neutral Near-Black     */
    --nx-accent-hover:  #262521;
    --nx-accent-soft:   rgba(55,53,47,.08);
    --nx-on-accent:     #ffffff;
    /* semantische Töne, leicht angewärmt — nur für Zahlen/Status */
    --nx-success:       #2f9e44;
    --nx-danger:        #e03131;
    --nx-warning:       #e8590c;
    --nx-info:          #1971c2;
    /* Form */
    --nx-radius-sm:     6px;
    --nx-radius:        8px;
    --nx-radius-lg:     12px;
    --nx-shadow:        none;
    --nx-shadow-pop:    0 6px 24px rgba(15,15,15,.10), 0 1px 3px rgba(15,15,15,.06);
    --nx-font:          -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
</style>