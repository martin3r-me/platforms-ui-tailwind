{{--
    nx-avatar — Profil-/Personenbild im nx-Stil: abgerundetes Quadrat (Button-Radius),
    kein Vollkreis. Zeigt das Bild oder – fehlt es – die Initiale auf accent-soft.

    <x-nx-avatar :name="$user->name" :src="$user->avatar" />
    <x-nx-avatar :name="$pu['name']" :src="$pu['avatar']" size="sm" status="online" ring />

      name   : für Initiale (Fallback) + title/alt
      src    : Bild-URL; leer -> Initiale
      size   : sm (24px) | md (28px, default) | lg (40px)
      status : null (default) | 'online' -> Punkt unten rechts (--nx-success)
      ring   : true -> Ring in Surface-Farbe (zum Überlappen/Stapeln)
--}}
@props([
    'name' => null,
    'src' => null,
    'size' => 'md',
    'status' => null,
    'ring' => false,
])

@php
    [$box, $text, $dot] = match ($size) {
        'sm'    => ['h-6 w-6', 'text-[10px]', 'h-2 w-2'],
        'lg'    => ['h-10 w-10', 'text-sm', 'h-2.5 w-2.5'],
        default => ['h-7 w-7', 'text-xs', 'h-2 w-2'],
    };
    $initial = strtoupper(mb_substr(trim((string) $name) ?: '?', 0, 1));
    $ringClass = $ring ? 'ring-2 ring-[color:var(--nx-surface)]' : '';
@endphp

<span {{ $attributes->class(['relative inline-flex shrink-0']) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $name }}" title="{{ $name }}"
             class="{{ $box }} {{ $ringClass }} rounded-[6px] object-cover" />
    @else
        <span title="{{ $name }}"
              class="{{ $box }} {{ $text }} {{ $ringClass }} flex items-center justify-center rounded-[6px] bg-[color:var(--nx-accent-soft)] font-medium text-[color:var(--nx-text)]">
            {{ $initial }}
        </span>
    @endif

    @if ($status === 'online')
        <span class="absolute -bottom-0.5 -right-0.5 {{ $dot }} rounded-full bg-[color:var(--nx-success)] ring-1 ring-[color:var(--nx-surface)]"></span>
    @endif
</span>
