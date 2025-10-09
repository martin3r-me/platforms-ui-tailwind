@props([
    'view' => 'board', // 'board' oder 'list'
    'showToggle' => false,
])

<div 
    x-data="{ 
        view: '{{ $view }}',
        toggleView() {
            this.view = this.view === 'board' ? 'list' : 'board';
            // Update Alpine Store für alle Komponenten
            Alpine.store('kanbanView', this.view);
            Alpine.store('plannerKanbanView', this.view);
        }
    }"
    x-init="Alpine.store('kanbanView', '{{ $view }}'); Alpine.store('plannerKanbanView', '{{ $view }}')"
    {{ $attributes->merge(['class' => 'h-full w-full']) }}
>
    @if($showToggle)
        <div class="mb-4 flex justify-end">
            <button 
                type="button"
                @click="toggleView()"
                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-md border transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                :class="view === 'board' 
                    ? 'bg-blue-600 text-white border-blue-600 hover:bg-blue-700' 
                    : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="view === 'board'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    <path x-show="view === 'list'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span x-text="view === 'board' ? 'Board' : 'Liste'"></span>
            </button>
        </div>
    @endif

    {{-- Board View --}}
    <div 
        x-show="Alpine.store('plannerKanbanView') === 'board'"
        x-cloak
        {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
            'class' => 'h-full min-h-0 w-full flex gap-4 px-4 py-3 overflow-x-auto'
        ]) }}
    >
        {{ $slot }}
    </div>

    {{-- List View --}}
    <div 
        x-show="Alpine.store('plannerKanbanView') === 'list'"
        x-cloak
        class="h-full min-h-0 w-full px-4 py-3 overflow-y-auto"
    >
        {{ $slot }}
    </div>
</div>