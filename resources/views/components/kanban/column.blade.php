@props([
    'title' => 'Unbenannt',
    'footer' => null,
    'scrollable' => true,
    'sortableId' => null,
])


<div 
    @if($sortableId)
        wire:sortable.item="{{ $sortableId }}"
        wire:key="column-{{ $sortableId }}"
    @endif
    {{ $attributes->merge(['class' => 'flex-shrink-0 h-full w-80 flex flex-col']) }}
>
    <div class="d-flex flex-col h-full" style="background-color:#fafafa;">
        
        <!-- Header -->
        <div class="p-3 text-md font-semibold uppercase tracking-wide d-flex justify-between items-center">
            {{ $title }}
            
                <!-- Nur hier: Drag-Handle für die ganze Spalte -->
                <button wire:sortable.handle class="text-primary" title="Spalte verschieben" style="cursor: grab;">
                    {{-- Du kannst hier statt ☰ auch ein Heroicon, Lucide oder FontAwesome Icon nehmen --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                    </svg>
                </button>
            
        </div>

        <!-- Extra Slot (z. B. Buttons, Filter, Menü) -->
        @isset($extra)
            <div class="p-2 border-bottom-1 border-muted bg-surface">
                {{ $extra }}
            </div>
        @endisset

        <!-- Body: Hier landen die Cards (sortable target) -->
        <div wire:sortable-group.item-group="{{ $sortableId }}" class="flex-grow px-3 py-3 gap-3 d-flex flex-col {{ $scrollable ? 'overflow-y-auto' : '' }}">
            {{ $slot }}
        </div>

        <!-- Footer (optional) -->
        @if($footer)
            <div class="px-4 py-3 border-top-1 border-muted bg-surface">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>