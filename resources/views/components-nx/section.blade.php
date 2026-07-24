{{--
    nx-section — ruhiger Notion-Section-Block: Header (kleines Icon + Titel +
    optionaler Zähler/Hint + Action) über dem Inhalt. Trägt keine Fläche/Rahmen
    selbst — Container (x-nx-card / Liste) kommen in den Slot.

    <x-nx-section icon="heroicon-o-flag" title="Meine Ziele" hint="3"
                  description="Relevante OKRs aus der Zeitplanung">
        <x-slot name="action"><x-nx-button variant="ghost" size="sm">Alle</x-nx-button></x-slot>
        …Inhalt…
    </x-nx-section>

      icon        : optionales Heroicon (faint)
      title       : Überschrift
      hint        : kleiner Zusatz rechts neben dem Titel (z. B. Anzahl)
      description : gedämpfte Unterzeile
--}}
@props([
    'icon' => null,
    'title' => null,
    'hint' => null,
    'description' => null,
])

<section {{ $attributes->class('space-y-3') }}>
    @if($title || $description || isset($action))
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    @if($icon)
                        @svg($icon, 'w-4 h-4 shrink-0 text-[color:var(--nx-faint)]')
                    @endif
                    @if($title)
                        <h2 class="truncate text-sm font-semibold text-[color:var(--nx-text)]">{{ $title }}</h2>
                    @endif
                    @if($hint !== null && $hint !== '')
                        <span class="shrink-0 text-xs text-[color:var(--nx-faint)] tabular-nums">{{ $hint }}</span>
                    @endif
                </div>
                @if($description)
                    <p class="mt-0.5 text-xs text-[color:var(--nx-faint)]">{{ $description }}</p>
                @endif
            </div>
            @isset($action)
                <div class="shrink-0">{{ $action }}</div>
            @endisset
        </div>
    @endif

    <div>{{ $slot }}</div>
</section>
