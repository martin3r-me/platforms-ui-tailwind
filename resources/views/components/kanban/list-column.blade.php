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
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        
        <!-- Header -->
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-900">{{ $title }}</h3>
            
            <div class="flex items-center gap-2">
                @isset($headerActions)
                    <div class="flex items-center gap-1">
                        {{ $headerActions }}
                    </div>
                @endisset
                
                @if($sortableId)
                    <button wire:sortable.handle class="text-gray-400 hover:text-gray-600 cursor-grab p-1" title="Spalte verschieben">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div 
            wire:sortable-group.item-group="{{ $sortableId }}" 
            class="divide-y divide-gray-200"
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
