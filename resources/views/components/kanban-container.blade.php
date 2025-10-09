@props([
    'sortable' => null,
    'sortableGroup' => null,
    'showToggle' => false,
    'view' => 'board',
])

<div class="flex-1 min-h-0 h-full overflow-x-auto overflow-y-hidden">
    @if($showToggle)
        <div class="mb-4 flex justify-end px-4">
            <button 
                type="button"
                x-data="{ 
                    view: '{{ $view }}',
                    toggleView() {
                        this.view = this.view === 'board' ? 'list' : 'board';
                        // Kein Livewire Event - nur lokaler State
                    }
                }"
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
    <x-ui-kanban-board 
        {{ $attributes->merge([
            'class' => 'h-full',
            'wire:sortable' => $sortable,
            'wire:sortable-group' => $sortableGroup,
            'show-toggle' => $showToggle,
            'view' => $view,
        ]) }}
    >
        {{ $slot }}
    </x-ui-kanban-board>
</div>
