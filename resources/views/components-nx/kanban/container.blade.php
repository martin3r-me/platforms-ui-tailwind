{{--
    nx-kanban-container — Board-/Listen-Umschalter + Sortable-Wurzel.
    API-kompatibel zu x-ui-kanban-container (sortable, sortableGroup). Notion:
    ruhige Fläche, flacher Umschalt-Button, großzügige Gaps.

      sortable      : wire:sortable-Methode (Spalten-Reihenfolge)
      sortableGroup : wire:sortable-group-Methode (Task-Verschiebung)
--}}
@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div class="relative h-full min-h-0 flex-1 overflow-hidden" x-data="{
    view: (localStorage.getItem('kanbanView') || 'board'),
    toggleView() {
        this.view = this.view === 'board' ? 'list' : 'board';
        localStorage.setItem('kanbanView', this.view);
        window.dispatchEvent(new Event('storage-change'));
    }
}">
    {{-- View-Umschalter: flach, unten rechts --}}
    <div class="absolute bottom-3 right-3 z-20">
        <button
            @click="toggleView()"
            class="inline-flex h-8 w-8 items-center justify-center rounded-[6px] border border-[color:var(--nx-line-strong)] bg-[color:var(--nx-surface)] text-[color:var(--nx-muted)] transition-colors hover:bg-[color:var(--nx-hover)] hover:text-[color:var(--nx-text)] focus:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--nx-line-strong)]"
            :title="view === 'board' ? 'Liste anzeigen' : 'Board anzeigen'"
        >
            <svg x-show="view === 'board'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            <svg x-show="view === 'list'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h6v12H4zM14 6h6v12h-6z" />
            </svg>
        </button>
    </div>

    {{-- Board-Ansicht --}}
    <div x-show="view === 'board'" class="flex h-full w-full gap-5 overflow-x-auto overflow-y-hidden px-4 py-3" wire:sortable="{{ $sortable }}" wire:sortable-group="{{ $sortableGroup }}">
        {{ $slot }}
    </div>

    {{-- Listen-Ansicht --}}
    <div x-show="view === 'list'" class="h-full w-full overflow-y-auto p-2 md:p-4" wire:sortable="{{ $sortable }}" wire:sortable-group="{{ $sortableGroup }}">
        <div class="w-full space-y-4 md:space-y-6">
            {{ $slot }}
        </div>
    </div>
</div>
