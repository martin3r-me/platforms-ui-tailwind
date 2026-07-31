{{--
    nx-figure — Bild/Diagramm mit optionaler Bildunterschrift.

    <x-nx-figure :src="$block['src']" :alt="$block['alt']" :caption="$block['caption'] ?? null" />

      src     : Bildquelle
      alt     : Alt-Text
      caption : optionale Unterschrift (zentriert, gedämpft)
--}}
@props(['src' => '', 'alt' => '', 'caption' => null])

<figure {{ $attributes->class('m-0') }}>
    <img src="{{ $src }}" alt="{{ $alt }}" loading="lazy"
         class="block max-w-full rounded-[8px] border border-[color:var(--nx-line)]">
    @if($caption)
        <figcaption class="mt-1.5 text-center text-xs text-[color:var(--nx-faint)]">{{ $caption }}</figcaption>
    @endif
</figure>
