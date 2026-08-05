{{--
    x-ui-scrollspy-nav — klebende Abschnitts-Navigation (nx-gestylt).
    Rendert den Slot (z. B. den Detail-Header) und darunter eine sticky Nav-Leiste,
    die zu den Sektionen mit id="sec-{key}" springt.

    $items: assoziativ  key => 'Label'  ODER  key => ['label' => …, 'count' => …]
    <x-ui-scrollspy-nav :items="$navItems"> … Header … </x-ui-scrollspy-nav>
--}}
@props(['items' => []])

<div class="space-y-4">
    {{ $slot }}

    @if(!empty($items))
        <nav class="sticky top-0 z-10 flex flex-wrap gap-1 border-b border-[color:var(--nx-line)] bg-[color:var(--nx-bg)] px-1 py-2">
            @foreach($items as $key => $item)
                @php
                    $label = is_array($item) ? ($item['label'] ?? $key) : $item;
                    $count = is_array($item) ? ($item['count'] ?? null) : null;
                @endphp
                <a href="#sec-{{ $key }}"
                   class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-sm text-[color:var(--nx-muted)] hover:bg-[color:var(--nx-hover)] hover:text-[color:var(--nx-text)]">
                    <span>{{ $label }}</span>
                    @if($count !== null)
                        <span class="rounded-full bg-[color:var(--nx-hover)] px-1.5 text-xs tabular-nums text-[color:var(--nx-faint)]">{{ $count }}</span>
                    @endif
                </a>
            @endforeach
        </nav>
    @endif
</div>
