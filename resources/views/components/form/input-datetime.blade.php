@props([
    'name',
    'label' => null,
    'value' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'required' => false,
    'placeholder' => null,
    'autocomplete' => null,
    'nullable' => true,
    'showTime' => true,
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'h-8 text-xs px-2',
        'sm' => 'h-9 text-sm px-3',
        'lg' => 'h-11 text-lg px-4',
        'xl' => 'h-12 text-xl px-5',
        default => 'h-10 text-base px-4',
    };
    $baseClasses = [
        'block w-full rounded-md bg-white text-[color:var(--ui-body-color)] placeholder-gray-400',
        'border border-[color:var(--ui-border)]',
        "focus:outline-none focus:ring-2 focus:ring-[color:rgba(var(--ui-{$variant}-rgb),0.2)] focus:border-[color:rgb(var(--ui-{$variant}-rgb))]",
        $sizeClass,
    ];
    
    // Format value for display
    $displayValue = null;
    $dateValue = null;
    $timeValue = null;
    
    if ($value) {
        try {
            if (is_string($value)) {
                $date = \Carbon\Carbon::parse($value);
            } elseif ($value instanceof \Carbon\Carbon) {
                $date = $value;
            } else {
                $date = null;
            }
            
            if ($date) {
                $displayValue = $date->format('d.m.Y H:i');
                $dateValue = $date->format('Y-m-d');
                $timeValue = $date->format('H:i');
            }
        } catch (\Exception $e) {
            $displayValue = null;
        }
    }
    
    $modalId = 'datetime-modal-' . str_replace(['[', ']', '.'], ['-', '', '-'], $name);
@endphp

<div x-data="{ 
    showModal: false, 
    selectedDate: '{{ $dateValue }}', 
    selectedTime: '{{ $timeValue }}',
    displayValue: '{{ $displayValue }}',
    
    init() {
        // Initialisierung beim Laden
        if (this.selectedDate && this.selectedTime) {
            this.displayValue = new Date(this.selectedDate + ' ' + this.selectedTime).toLocaleDateString('de-DE') + ' ' + new Date(this.selectedDate + ' ' + this.selectedTime).toLocaleTimeString('de-DE', {hour: '2-digit', minute: '2-digit'});
        }
    },
    
    openModal() {
        this.showModal = true;
    },
    
    closeModal() {
        this.showModal = false;
    },
    
    clearDateTime() {
        this.selectedDate = '';
        this.selectedTime = '{{ $showTime ? '12:00' : '00:00' }}';
        this.displayValue = '';
        this.updateInput();
    },
    
    applyDateTime() {
        if (this.selectedDate) {
            const time = this.selectedTime || '{{ $showTime ? '12:00' : '00:00' }}';
            const datetime = this.selectedDate + ' ' + time;
            this.displayValue = new Date(datetime).toLocaleDateString('de-DE') + ' ' + new Date(datetime).toLocaleTimeString('de-DE', {hour: '2-digit', minute: '2-digit'});
            this.updateInput();
        } else {
            this.displayValue = '';
            this.updateInput();
        }
        this.closeModal();
    },
    
    updateInput() {
        const input = document.getElementById('{{ $name }}');
        if (this.selectedDate) {
            const time = this.selectedTime || '{{ $showTime ? '12:00' : '00:00' }}';
            const datetime = this.selectedDate + ' ' + time;
            input.value = datetime;
        } else {
            input.value = '';
        }
        // Livewire Event für wire:model.live
        input.dispatchEvent(new Event('input', { bubbles: true }));
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }
}">
    @if($label)
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
    @endif

    <div class="relative">
        <input
            type="hidden"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            {{ $attributes->merge(['class' => implode(' ', $baseClasses)]) }}
        />
        
        <button
            type="button"
            @click="openModal()"
            class="w-full text-left {{ implode(' ', $baseClasses) }} cursor-pointer flex items-center justify-between"
        >
            <span x-text="displayValue || '{{ $placeholder ?: 'Datum und Zeit auswählen...' }}'" 
                  :class="displayValue ? 'text-gray-900' : 'text-gray-400'"></span>
            <div class="flex items-center gap-2">
                @if($nullable && $displayValue)
                    <button
                        type="button"
                        @click.stop="clearDateTime()"
                        class="text-gray-400 hover:text-gray-600 transition-colors"
                        title="Datum löschen"
                    >
                        @svg('heroicon-o-x-mark', 'w-4 h-4')
                    </button>
                @endif
                @svg('heroicon-o-calendar', 'w-4 h-4 text-gray-400')
            </div>
        </button>
    </div>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror

    {{-- Modal --}}
    <div x-show="showModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50" @click="closeModal()"></div>
            
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                {{-- Header --}}
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Datum und Zeit auswählen</h3>
                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                        @svg('heroicon-o-x-mark', 'w-5 h-5')
                    </button>
                </div>
                
                {{-- Content --}}
                <div class="p-6 space-y-6">
                    {{-- Date Picker --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Datum</label>
                        <input
                            type="date"
                            x-model="selectedDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                    
                    @if($showTime)
                        {{-- Time Picker --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Zeit</label>
                            <input
                                type="time"
                                x-model="selectedTime"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                    @endif
                    
                    {{-- Preview --}}
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Vorschau:</div>
                        <div class="font-medium text-gray-900" x-text="selectedDate ? new Date(selectedDate + ' ' + (selectedTime || '12:00')).toLocaleDateString('de-DE') + ' ' + new Date(selectedDate + ' ' + (selectedTime || '12:00')).toLocaleTimeString('de-DE', {hour: '2-digit', minute: '2-digit'}) : 'Kein Datum ausgewählt'"></div>
                    </div>
                </div>
                
                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200">
                    <button
                        type="button"
                        @click="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Abbrechen
                    </button>
                    <button
                        type="button"
                        @click="applyDateTime()"
                        :disabled="!selectedDate"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Übernehmen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
