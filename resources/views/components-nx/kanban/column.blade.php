{{--
    nx-kanban-column — Notion-Slot: gerundeter Container mit hauchzartem
    Ton-Wash. Header = Ton-Punkt + Label in weicher Ton-Pille + Count. Die
    weißen Karten (x-nx-kanban-card) liegen mit weichem Schatten darauf.

      title      : Spaltenname
      tone       : rose|amber|emerald|teal|sky|indigo|violet|pink|slate → Wash + Pille + Punkt
      count      : optionale Anzahl neben dem Titel
      sortableId : Spalten-Drag + Task-Drop-Zone
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

@php
    $dot    = $tone ? "var(--nx-tone-{$tone})" : 'var(--nx-faint)';
    $slotBg = $tone ? "color-mix(in srgb, var(--nx-tone-{$tone}) 6%, #ffffff)" : 'var(--nx-bg)';
    $pillBg = $tone ? "color-mix(in srgb, var(--nx-tone-{$tone}) 16%, #ffffff)" : 'var(--nx-accent-soft)';
@endphp

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
    <div class="flex h-full flex-col rounded-[10px] p-1.5" style="background-color: {{ $slotBg }};">
        {{-- Header: Ton-Pille (Punkt + Label) + Count --}}
        <div class="flex items-center justify-between px-1.5 py-1.5 {{ $muted ? 'opacity-80' : '' }}">
            <div class="flex min-w-0 items-center gap-1.5">
                <span class="inline-flex min-w-0 items-center gap-1.5 rounded-[6px] px-2 py-0.5" style="background-color: {{ $pillBg }};">
                    <span class="h-2 w-2 shrink-0 rounded-full" style="background-color: {{ $dot }};"></span>
                    <span class="truncate text-xs font-medium text-[color:var(--nx-text)]">{{ $title }}</span>
                </span>
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
            class="min-h-0 flex-1 px-0.5"
            :class="{ 'overflow-y-auto': scrollable }"
        >
            {{ $slot }}
        </div>

        @if($footer)
            <div class="px-1.5 py-1.5">{{ $footer }}</div>
        @endif
    </div>
</div>

<style>
    /* Spalten-Drag dezent (nx) */
    .kanban-column.wire-sortable-placeholder > div {
        outline: 1px dashed var(--nx-line-strong);
        outline-offset: -1px;
    }
</style>
