{{--
    nx-kanban-column — Notion-Spalte: keine Fläche, kein Rahmen. Nur ein
    ruhiger Header (optionaler Ton-Punkt + Titel + Count) und die flache Liste.
    API-kompatibel zu x-ui-kanban-column; NEU: tone + count statt col-tone-*-CSS.

      title      : Spaltenname
      tone       : rose|amber|emerald|teal|sky|indigo|violet|pink|slate → Farb-Punkt (--nx-tone-*)
      count      : optionale Anzahl neben dem Titel
      sortableId : aktiviert Spalten-Drag + Task-Drop-Zone
      scrollable : Body scrollt (default true)
      muted      : gedämpfte Spalte (Backlog/Erledigt)
      footer / headerActions : Slots
--}}
@props([
    'title' => 'Unbenannt',
    'sortableId' => null,
    'scrollable' => true,
    'footer' => null,
    'muted' => false,
    'tone' => null,
    'count' => null,
])

<div
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'kanban-column flex h-full flex-shrink-0 flex-col', 'style' => 'width:19rem;min-width:19rem']) }}
    x-data="{ isList: localStorage.getItem('kanbanView') === 'list', scrollable: {{ $scrollable ? 'true' : 'false' }} }"
    x-init="this.isList = localStorage.getItem('kanbanView') === 'list'"
    @storage-change.window="isList = localStorage.getItem('kanbanView') === 'list'"
    :style="isList ? 'width:100%;min-width:0' : 'width:19rem;min-width:19rem'"
>
    <div class="flex h-full flex-col">
        {{-- Header: Ton-Punkt + Titel + Count --}}
        <div class="flex items-center justify-between px-2 py-2 {{ $muted ? 'opacity-70' : '' }}">
            <div class="flex min-w-0 items-center gap-2">
                @if($tone)
                    <span class="h-2 w-2 shrink-0 rounded-full" style="background-color: var(--nx-tone-{{ $tone }})"></span>
                @endif
                <span class="truncate text-xs font-semibold uppercase tracking-wide {{ $muted ? 'text-[color:var(--nx-faint)]' : 'text-[color:var(--nx-muted)]' }}">{{ $title }}</span>
                @if(!is_null($count))
                    <span class="shrink-0 text-xs text-[color:var(--nx-faint)]">{{ $count }}</span>
                @endif
            </div>

            <div class="flex items-center gap-1">
                @isset($headerActions)
                    <div class="flex items-center gap-1">{{ $headerActions }}</div>
                @endisset

                @if($sortableId)
                    <button wire:sortable.handle class="cursor-grab rounded-[6px] p-1 text-[color:var(--nx-faint)] transition-colors hover:bg-[color:var(--nx-hover)] hover:text-[color:var(--nx-text)]" title="Spalte verschieben">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        {{-- Body --}}
        <div
            wire:sortable-group.item-group="{{ $sortableId }}"
            class="min-h-0 flex-1"
            :class="{ 'overflow-y-auto': scrollable }"
        >
            {{ $slot }}
        </div>

        @if($footer)
            <div class="px-1 py-2">{{ $footer }}</div>
        @endif
    </div>
</div>

<style>
    /* Spalten-Drag dezent (nx) */
    .kanban-column.wire-sortable-placeholder > div {
        background: var(--nx-hover);
        border-radius: 8px;
    }
</style>
