{{--
    nx-panel — Notion-Grundfläche mit optionalem Kopf (Titel/Untertitel + actions-Slot).
    Wie x-nx-card, aber mit Header-Zeile — sauberer Ersatz für das alte x-ui-panel.

    <x-nx-panel title="Alle Beschäftigten" subtitle="…" flush>
        <x-slot name="actions"><x-nx-badge>{{ $total }}</x-nx-badge></x-slot>
        …Inhalt…
    </x-nx-panel>

      title / subtitle : Kopf-Texte (Kopf entfällt, wenn beide leer und kein actions-Slot)
      flush            : true -> Inhalt ohne Padding (z. B. für Tabellen)
--}}
@props([
    'title' => null,
    'subtitle' => null,
    'flush' => false,
])

<div {{ $attributes->class('rounded-[8px] bg-[color:var(--nx-surface)] border border-[color:var(--nx-line)] text-[color:var(--nx-text)]') }}>
    @if($title || $subtitle || isset($actions))
        <div class="flex items-start justify-between gap-3 border-b border-[color:var(--nx-line)] px-4 py-3">
            <div class="min-w-0">
                @if($title)
                    <h3 class="m-0 truncate text-sm font-semibold text-[color:var(--nx-text)]">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <div class="text-xs text-[color:var(--nx-muted)]">{{ $subtitle }}</div>
                @endif
            </div>
            @isset($actions)
                <div class="shrink-0">{{ $actions }}</div>
            @endisset
        </div>
    @endif
    <div class="{{ $flush ? '' : 'p-4' }}">
        {{ $slot }}
    </div>
</div>
