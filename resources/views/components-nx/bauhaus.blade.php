{{--
    nx-bauhaus — generative, gesäte Bauhaus-Komposition (gedämpfte, warme Palette).
    Füllt das (relativ positionierte) Elternelement.

    <x-nx-bauhaus :seed="$id" :count="7" />
      seed   — gleicher Seed = gleiche Komposition (stabil bei Re-Render); weglassen = zufällig
      count  — Anzahl Formen (Default 7)
--}}
@props(['seed' => null, 'count' => 7])
@php
    if ($seed !== null) { mt_srand((int) crc32((string) $seed)); }

    // Gedämpfte, warme Palette — Zufall bleibt dadurch immer geschmackvoll
    $palette = ['#6f8ca8', '#bd7358', '#cca25a', '#2b2a26', '#8a9a8e', '#c9c3b8'];
    $rand = fn ($a, $b) => mt_rand($a, $b);
    $pick = fn ($arr) => $arr[mt_rand(0, count($arr) - 1)];

    $shapes = [];
    for ($i = 0; $i < (int) $count; $i++) {
        $type  = $pick(['disc', 'disc', 'ring', 'rect', 'bar', 'line']);
        $color = $pick($palette);
        $left  = $rand(2, 78);
        $top   = $rand(2, 78);
        $s     = $rand(8, 34);   // Kreis-Durchmesser in %
        $w     = $rand(14, 44);  // Rechteck-Breite %
        $h     = $rand(6, 32);   // Rechteck/Linien-Höhe %
        $rot   = $rand(0, 180);
        $bw    = $rand(2, 5);    // Ring-/Linienstärke

        $st = "position:absolute;left:{$left}%;top:{$top}%;";
        $st .= match ($type) {
            'disc' => "width:{$s}%;padding-bottom:{$s}%;border-radius:50%;background:{$color};",
            'ring' => "width:{$s}%;padding-bottom:{$s}%;border-radius:50%;border:{$bw}px solid {$color};",
            'rect' => "width:{$w}%;height:{$h}%;background:{$color};",
            'bar'  => "width:{$w}%;height:3px;background:{$color};",
            'line' => "width:2px;height:{$h}%;background:{$color};transform:rotate({$rot}deg);transform-origin:top center;",
        };
        $shapes[] = $st;
    }

    if ($seed !== null) { mt_srand(); } // globalen RNG wieder freigeben
@endphp
<div {{ $attributes->merge(['class' => 'absolute inset-0 overflow-hidden']) }} aria-hidden="true">
    @foreach ($shapes as $st)
        <span style="{{ $st }}"></span>
    @endforeach
</div>
