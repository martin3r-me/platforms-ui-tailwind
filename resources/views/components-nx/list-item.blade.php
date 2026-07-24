{{--
    nx-list-item — eine Hairline-Zeile der „Liste"-Grammatik (Katalog/Entitäten):
    Leading (Icon/Avatar) · Titel + optionale Unterzeile · Meta · Trailing.
    Zeile klickbar = Hauptaktion (href). Gehört in einen Container mit
    Hairline-Trennern, z. B. <x-nx-card flush> + <ul class="divide-y divide-[color:var(--nx-line)]">.

    <x-nx-list-item icon="heroicon-o-clipboard-document-check"
                    title="Angebot Rheingedeck" meta="fällig morgen" :href="$url">
        <x-slot name="trailing"><x-nx-badge variant="warning">offen</x-nx-badge></x-slot>
    </x-nx-list-item>

      icon     : optionales Heroicon (faint); alternativ 'leading'-Slot (z. B. Avatar)
      title    : Haupttext
      subtitle : gedämpfte Unterzeile
      meta     : kleiner rechtsbündiger Zusatz (Datum/Zahl)
      href     : rendert <a> mit wire:navigate + Hover (Zeile klickbar)
      trailing : Slot rechts (Badges/Hover-Aktionen)
--}}
@props([
    'icon' => null,
    'title' => null,
    'subtitle' => null,
    'meta' => null,
    'href' => null,
])

@php $tag = $href ? 'a' : 'div'; @endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" wire:navigate @endif
    {{ $attributes->class([
        'flex items-center gap-3 px-4 py-2.5',
        'transition-colors hover:bg-[color:var(--nx-hover)]' => (bool) $href,
    ]) }}>

    @isset($leading)
        <span class="shrink-0">{{ $leading }}</span>
    @elseif($icon)
        @svg($icon, 'w-4 h-4 shrink-0 text-[color:var(--nx-faint)]')
    @endif

    <span class="min-w-0 flex-1">
        @if($title)
            <span class="block truncate text-sm text-[color:var(--nx-text)]">{{ $title }}</span>
        @endif
        @if($subtitle)
            <span class="block truncate text-xs text-[color:var(--nx-faint)]">{{ $subtitle }}</span>
        @endif
        {{ $slot }}
    </span>

    @if($meta !== null && $meta !== '')
        <span class="shrink-0 text-xs text-[color:var(--nx-faint)] tabular-nums">{{ $meta }}</span>
    @endif

    @isset($trailing)
        <span class="flex shrink-0 items-center gap-1.5">{{ $trailing }}</span>
    @endisset
</{{ $tag }}>
