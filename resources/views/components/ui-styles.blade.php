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
    --nx-bg:            #f4f3ee;               /* warmes Off-White (Chrome/Seite) */
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
    /* Tone-Palette (Notion-artig, gedämpft) — Label-/Spalten-Punkte, Tags,
       Kategorien. Bedeutung liegt beim Nutzer, nicht im Status. Zentral tunbar. */
    --nx-tone-rose:     #c15b58;
    --nx-tone-amber:    #cb7b2e;
    --nx-tone-emerald:  #4f9d69;
    --nx-tone-teal:     #3d9797;
    --nx-tone-sky:      #4a8dbf;
    --nx-tone-indigo:   #6b6fc4;
    --nx-tone-violet:   #8b6fc0;
    --nx-tone-pink:     #c56b9e;
    --nx-tone-slate:    #8a8a86;
    /* Form */
    --nx-radius-sm:     6px;
    --nx-radius:        8px;
    --nx-radius-lg:     12px;
    --nx-shadow:        none;
    --nx-shadow-card:   0 1px 2px rgba(15,15,15,.045), 0 2px 6px rgba(15,15,15,.035);  /* Notion: Kachel liegt weich auf */
    --nx-shadow-pop:    0 6px 24px rgba(15,15,15,.10), 0 1px 3px rgba(15,15,15,.06);
    --nx-font:          -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

/* =======================================================================
   nx-prose — Notion-artige Typografie für gerendertes Markdown
   (Str::markdown()-Output). Ersetzt das nicht geladene Tailwind-Typography.
   Nutzung: div.nx-prose um den Str::markdown()-HTML-Output wickeln.
   ======================================================================= */
.nx-prose {
    color: var(--nx-text);
    font-size: 14px;
    line-height: 1.65;
    word-break: break-word;
}
.nx-prose > :first-child { margin-top: 0; }
.nx-prose > :last-child  { margin-bottom: 0; }
.nx-prose h1, .nx-prose h2, .nx-prose h3, .nx-prose h4, .nx-prose h5, .nx-prose h6 {
    color: var(--nx-text);
    font-weight: 600;
    line-height: 1.3;
    margin: 1.6em 0 .55em;
}
.nx-prose h1 { font-size: 1.4em; letter-spacing: -.01em; }
.nx-prose h2 { font-size: 1.2em; letter-spacing: -.01em; }
.nx-prose h3 { font-size: 1.05em; }
.nx-prose h4, .nx-prose h5, .nx-prose h6 { font-size: .95em; }
.nx-prose p { margin: 0 0 .8em; }
.nx-prose ul, .nx-prose ol { margin: 0 0 .8em; padding-left: 1.4em; }
.nx-prose ul { list-style: disc; }
.nx-prose ol { list-style: decimal; }
.nx-prose li { margin: .2em 0; padding-left: .15em; }
.nx-prose li::marker { color: var(--nx-faint); }
.nx-prose ul ul, .nx-prose ol ol, .nx-prose ul ol, .nx-prose ol ul { margin: .2em 0 .3em; }
.nx-prose strong, .nx-prose b { font-weight: 600; color: var(--nx-text); }
.nx-prose em, .nx-prose i { font-style: italic; }
.nx-prose a { color: var(--nx-accent); text-decoration: underline; text-underline-offset: 2px; text-decoration-color: var(--nx-line-strong); }
.nx-prose a:hover { text-decoration-color: var(--nx-accent); }
.nx-prose code {
    font-family: var(--nx-font-mono, ui-monospace, SFMono-Regular, Menlo, monospace);
    font-size: .86em;
    background: var(--nx-bg);
    border: 1px solid var(--nx-line);
    border-radius: 4px;
    padding: .08em .35em;
}
.nx-prose pre {
    background: var(--nx-bg);
    border: 1px solid var(--nx-line);
    border-radius: var(--nx-radius-sm);
    padding: .8em 1em;
    overflow-x: auto;
    margin: 0 0 .8em;
    font-size: .86em;
    line-height: 1.5;
}
.nx-prose pre code { background: none; border: 0; padding: 0; font-size: 1em; }
.nx-prose blockquote {
    border-left: 3px solid var(--nx-line-strong);
    padding: .1em 0 .1em 1em;
    margin: 0 0 .8em;
    color: var(--nx-muted);
}
.nx-prose hr { border: 0; border-top: 1px solid var(--nx-line); margin: 1.4em 0; }
.nx-prose table { width: 100%; border-collapse: collapse; margin: 0 0 .8em; font-size: .95em; }
.nx-prose th, .nx-prose td { border: 1px solid var(--nx-line); padding: .4em .6em; text-align: left; }
.nx-prose th { background: var(--nx-bg); font-weight: 600; }
.nx-prose img { max-width: 100%; border-radius: var(--nx-radius-sm); }
</style>