@props([
    'title' => 'Unbenannt',
    'sortableId' => null,
    'scrollable' => true,
    'footer' => null,
    'muted' => false,
])

<div 
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'w-full mb-6']) }}
>
    <div class="flex flex-col bg-white border border-gray-200 rounded-lg shadow-sm">
        
        <!-- Header -->
        <div class="p-3 text-xs font-semibold uppercase tracking-wide flex justify-between items-center border-b border-gray-200">
            <span class="text-gray-700 flex-1 truncate">{{ $title }}</span>
            
            <div class="flex items-center gap-2">
                @isset($headerActions)
                    <div class="flex items-center gap-1">
                        {{ $headerActions }}
                    </div>
                @endisset
                
                @if($sortableId)
                    <button wire:sortable.handle class="text-blue-600 cursor-grab" title="Spalte verschieben">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div 
            wire:sortable-group.item-group="{{ $sortableId }}" 
            class="flex-1 min-h-0 px-3 py-3 space-y-2 {{ $scrollable ? 'overflow-y-auto' : '' }}"
        >
            {{ $slot }}
        </div>

        @if($footer)
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
