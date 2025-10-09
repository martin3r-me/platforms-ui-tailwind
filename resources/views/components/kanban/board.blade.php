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
            // Speichere im Local Storage
            localStorage.setItem('plannerKanbanView', this.view);
        }
    }"
    x-init="Alpine.store('kanbanView', '{{ $view }}'); Alpine.store('plannerKanbanView', '{{ $view }}')"
    {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
        'class' => 'h-full w-full'
    ]) }}
>

    {{-- Board View --}}
    <div 
        x-show="Alpine.store('plannerKanbanView') === 'board'"
        x-cloak
        class="h-full min-h-0 w-full flex gap-4 px-4 py-3 overflow-x-auto"
    >
        {{ $slot }}
    </div>

    {{-- List View --}}
    <div 
        x-show="Alpine.store('plannerKanbanView') === 'list'"
        x-cloak
        class="h-full min-h-0 w-full px-4 py-3 overflow-y-auto"
    >
        <div class="space-y-8">
            {{ $slot }}
        </div>
    </div>
</div>