{{--
    nx-property-row — Notion-Property-Zeile: Icon + Label (fix) + Wert/Editor (flex).
    Für Detail-Seiten, wo Eigenschaften inline im Content liegen (statt in einer
    Sidebar). Wert-Slot nimmt Text, Button, nx-input-* etc.

    <x-nx-property-row icon="heroicon-o-flag" label="Priorität">
        <x-nx-input-select … />
    </x-nx-property-row>

      icon  : Heroicon-Name (optional)
      label : Property-Name (gedämpft)
--}}
@props([
    'icon' => null,
    'label' => '',
])

<div {{ $attributes->class(['flex items-center gap-3 px-2 py-1.5 rounded-[6px] transition-colors hover:bg-[color:var(--nx-hover)]']) }}>
    <div class="flex w-40 shrink-0 items-center gap-2 text-[color:var(--nx-muted)]">
        @if($icon)
            @svg($icon, 'w-4 h-4 shrink-0 opacity-80')
        @endif
        <span class="truncate text-xs">{{ $label }}</span>
    </div>
    <div class="min-w-0 flex-1 text-sm text-[color:var(--nx-text)]">
        {{ $slot }}
    </div>
</div>
