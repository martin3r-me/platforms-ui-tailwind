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
}
</style>