@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div class="flex-1 min-h-0 h-full overflow-hidden relative" x-data="{ 
    view: (localStorage.getItem('kanbanView') || 'board'),
    toggleView() { 
        this.view = this.view === 'board' ? 'list' : 'board'; 
        localStorage.setItem('kanbanView', this.view);
        window.dispatchEvent(new Event('storage-change'));
    } 
}">
    <!-- Toggle: kompakt unten rechts -->
    <div class="absolute bottom-3 right-3 z-20">
        <button
            @click="toggleView()"
            class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-[var(--ui-border)] bg-white/80 backdrop-blur shadow-md text-[var(--ui-secondary)] hover:bg-white hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/30"
            :title="view === 'board' ? 'Liste anzeigen' : 'Board anzeigen'"
        >
            <svg x-show="view === 'board'" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            <svg x-show="view === 'list'" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h6v12H4zM14 6h6v12h-6z" />
            </svg>
        </button>
    </div>

    <!-- Board View -->
    <div x-show="view === 'board'" class="h-full w-full flex gap-4 overflow-x-auto overflow-y-hidden p-2" wire:sortable="{{ $sortable }}" wire:sortable-group="{{ $sortableGroup }}">
        {{ $slot }}
    </div>

    <!-- List View -->
    <div x-show="view === 'list'" class="h-full w-full overflow-y-auto p-2 md:p-4" wire:sortable="{{ $sortable }}" wire:sortable-group="{{ $sortableGroup }}">
        <div class="space-y-4 md:space-y-6 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
