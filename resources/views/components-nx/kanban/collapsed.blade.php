{{--
    nx-kanban-collapsed — eingeklappte Spalte als schmaler Streifen am rechten Board-Rand
    (Erledigt, Gewonnen, Verloren …). Im Board klebt er rechts (sticky), in der Listen-Ansicht
    wird er zur Leiste unten. Klick-Verhalten kommt vom Aufrufer (wire:click / @click).

      title  : Spaltenname (im Board senkrecht)
      count  : Anzahl im Zähler
      tone   : emerald|rose|amber|… → Farbe von Pfeil, Titel, Zähler
      offset : Anzahl Streifen, die rechts davon kleben (mehrere Streifen nebeneinander)
               — gedacht für nx-kanban-container (px-4)

    Beispiel:
      <x-nx-kanban-collapsed title="Erledigt" :count="$done->count()" wire:click="toggleShowDoneColumn" />
--}}
@props([
    'title' => 'Erledigt',
    'count' => null,
    'tone' => 'emerald',
    'offset' => 0,
])

@php
    $color = "var(--nx-tone-{$tone})";
    $soft = "color-mix(in srgb, var(--nx-tone-{$tone}) 16%, transparent)";
    // -1rem gleicht das px-4 des nx-kanban-containers aus: Chrome lässt sticky sonst vor dem Innenabstand enden
    $shift = 'calc(' . (int) $offset . ' * 2.75rem - 1rem)';
    $lift = 'calc(' . (int) $offset . ' * 2.75rem)';
@endphp

<button
    type="button"
    {{ $attributes->merge(['title' => $title . ' anzeigen' . (is_null($count) ? '' : " ({$count})")]) }}
    x-data="{ isList: localStorage.getItem('kanbanView') === 'list' }"
    @storage-change.window="isList = localStorage.getItem('kanbanView') === 'list'"
    :class="isList
        ? 'nx-kanban-collapsed sticky z-20 flex w-full flex-row items-center justify-start gap-3 border-t px-4 py-3 pr-14'
        : 'nx-kanban-collapsed sticky z-10 flex h-full flex-shrink-0 flex-col items-center gap-2 border-l px-2 py-4'"
    :style="isList ? 'color: {{ $color }}; bottom: {{ $lift }}' : 'color: {{ $color }}; right: {{ $shift }}; width: 2.75rem; min-width: 2.75rem'"
    style="color: {{ $color }}; right: {{ $shift }}; width: 2.75rem; min-width: 2.75rem"
>
    <span x-show="!isList">@svg('heroicon-o-chevron-double-left', 'w-4 h-4 mt-1')</span>
    <span x-show="isList" style="display: none">@svg('heroicon-o-chevron-double-up', 'w-4 h-4')</span>

    {{-- Zähler oben: unten rechts liegt der Board/Listen-Umschalter --}}
    @if(!is_null($count))
        <span class="inline-flex h-5 min-w-[1.5rem] items-center justify-center rounded-full px-1 text-[10px] font-semibold tabular-nums" style="background-color: {{ $soft }}">{{ $count }}</span>
    @endif

    <span
        class="text-[10px] font-bold uppercase tracking-wider"
        :style="!isList ? 'writing-mode: vertical-rl; transform: rotate(180deg); margin-top: 4px' : ''"
    >{{ $title }}</span>

    <span x-show="isList" style="display: none" class="ml-auto mr-2 text-[11px] text-[color:var(--nx-muted)]">Klick zum Anzeigen</span>
</button>

<style>
    .nx-kanban-collapsed { background: var(--nx-surface, #fff); border-color: var(--nx-line, rgba(55, 53, 47, .09)); transition: background-color .12s; }
    .nx-kanban-collapsed:hover { background: var(--nx-hover, rgba(55, 53, 47, .06)); }
</style>
