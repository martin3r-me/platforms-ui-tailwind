@props([
    'model' => 'modalShow',      // Livewire property name
    'size' => 'md',              // sm, md, lg, full
    'backdropClosable' => true,  // Overlay-Klick erlaubt?
    'escClosable' => true,       // ESC erlaubt?
    'persistent' => false,       // Sperrt ESC + Overlay-Klick komplett
])

@php
    $validSizes = ['sm', 'md', 'lg', 'full'];
    if (!in_array($size, $validSizes)) {
        $size = 'md';
    }

    $sizeClasses = match($size) {
        'sm'   => 'max-w-md max-h-3/5',           // ~448px, 60% Höhe
        'lg'   => 'max-w-7xl max-h-4/5',          // ~1280px, 80% Höhe
        'full' => 'w-screen h-screen max-w-none max-h-none', // Vollbild
        default => 'max-w-3xl max-h-4/5',         // Standard (~768px)
    };

    $modalExtraClasses = $size === 'full'
        ? 'rounded-0 bg-white'
        : 'rounded-lg bg-surface';

    $canCloseByBackdrop = !$persistent && $backdropClosable;
    $canCloseByEsc = !$persistent && $escClosable;
@endphp

<div 
    x-data="{ modalShow: $wire.entangle('{{ $model }}') }"
    x-init="console.log('Init:', modalShow)"
    x-show="modalShow"
    x-cloak
>
    <div
        class="position-fixed inset-0 z-100 d-flex justify-center items-center"
        @keydown.window.escape="{{ $canCloseByEsc ? 'modalShow = false' : '' }}"
    >
        <!-- Overlay -->
        <div 
            class="position-absolute inset-0 bg-blur bg-black-80 z-90"
            @click="{{ $canCloseByBackdrop ? 'modalShow = false' : '' }}">
        </div>

        <!-- Modal -->
        <div 
            class="shadow-lg w-full p-0 position-relative z-100
                   d-flex flex-col h-full overflow-hidden
                   {{ $sizeClasses }} {{ $modalExtraClasses }}"
        >
            <!-- Header -->
            @if (trim($header ?? ''))
                <div class="p-4 border-bottom-1 border-bottom-solid border-bottom-muted d-flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-secondary m-0">
                        {{ $header }}
                    </h2>
                    <x-ui-button
                        @click="modalShow = false"
                        variant="danger-outline"
                        size="sm"
                        aria-label="Schließen"
                    >
                        <x-heroicon-o-x-mark class="w-3 h-3" />
                    </x-ui-button>
                </div>
            @endif

            <!-- Body -->
            <div class="p-8 flex-grow overflow-y-auto">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if (isset($footer))
                <div class="p-4 border-top-1 border-top-solid border-top-muted d-flex justify-end gap-2">
                    {{ $footer }}
                </div>
            @else
                <div class="p-4 border-top-1 border-top-solid border-top-muted d-flex justify-end gap-2">
                    <x-ui-button variant="danger-outline" size="sm" @click="modalShow = false">
                        Abbrechen
                    </x-ui-button>
                </div>
            @endif
        </div>
    </div>
</div>