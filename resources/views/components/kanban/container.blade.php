@props([
    'sortable' => null,
    'sortableGroup' => null,
])

<div class="flex-1 min-h-0 h-full overflow-hidden relative" x-data="{ view: 'board', toggleView() { this.view = this.view === 'board' ? 'list' : 'board'; localStorage.setItem('kanbanView', this.view); } }" x-init="(() => { const savedView = localStorage.getItem('kanbanView') || 'board'; this.view = savedView; })()">
    <!-- Schwebt über dem Board -->
    <div class="absolute top-4 right-4 z-10">
        <button 
            @click="toggleView()"
            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-md border transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg bg-white/90 backdrop-blur-sm"
            :class="view === 'board' ? 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700' : 'bg-white/95 text-gray-800 border-gray-300 hover:bg-gray-50'"
        >
            <svg x-show="view === 'board'" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            <svg x-show="view === 'list'" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
            <span x-text="view === 'board' ? 'Board' : 'Liste'"></span>
        </button>
    </div>

    <x-ui-kanban-board 
        wire:sortable="{{ $sortable }}"
        wire:sortable-group="{{ $sortableGroup }}"
        class="h-full"
    >
        {{ $slot }}
    </x-ui-kanban-board>
</div>
