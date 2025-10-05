@props([
    'model' => 'modalShow',
    'size' => 'md',
    'backdropClosable' => true,
    'escClosable' => true,
    'persistent' => false,
])

@php
    $validSizes = ['sm', 'md', 'lg', 'full'];
    if (!in_array($size, $validSizes)) {
        $size = 'md';
    }

    $sizeClasses = match($size) {
        'sm'   => 'max-w-md max-h-[60vh]',
        'lg'   => 'max-w-7xl max-h-[80vh]',
        'full' => 'w-screen h-screen max-w-none max-h-none',
        default => 'max-w-3xl max-h-[80vh]',
    };

    $modalExtraClasses = $size === 'full'
        ? 'rounded-none bg-white'
        : 'rounded-lg bg-[color:var(--ui-surface)] text-[color:var(--ui-surface-color)]';

    $canCloseByBackdrop = !$persistent && $backdropClosable;
    $canCloseByEsc = !$persistent && $escClosable;
@endphp

<div 
    x-data="{ modalShow: $wire.entangle('{{ $model }}') }"
    x-show="modalShow"
    x-cloak
>
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center"
        @keydown.window.escape="{{ $canCloseByEsc ? 'modalShow = false' : '' }}"
    >
        <!-- Overlay -->
        <div 
            class="absolute inset-0 backdrop-blur-sm bg-black/80 z-[90]"
            @click="{{ $canCloseByBackdrop ? 'modalShow = false' : '' }}">
        </div>

        <!-- Modal -->
        <div 
            class="shadow-lg w-full p-0 relative z-[100] flex flex-col h-full overflow-hidden border border-[color:var(--ui-border)] {{ $sizeClasses }} {{ $modalExtraClasses }}"
        >
            <!-- Header -->
            @if (trim($header ?? ''))
                <div class="p-4 border-b border-[color:var(--ui-border)] flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-[color:var(--ui-body-color)] m-0">
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
            <div class="p-8 flex-1 overflow-y-auto">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if (isset($footer))
                <div class="p-4 border-t border-[color:var(--ui-border)] flex justify-end gap-2">
                    {{ $footer }}
                </div>
            @else
                <div class="p-4 border-t border-[color:var(--ui-border)] flex justify-end gap-2">
                    <x-ui-button variant="danger-outline" size="sm" @click="modalShow = false">
                        Abbrechen
                    </x-ui-button>
                </div>
            @endif
        </div>
    </div>
</div>