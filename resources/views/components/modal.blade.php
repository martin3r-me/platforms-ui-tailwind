@props([
    'model' => 'modalShow',
    'size' => 'md',
    'backdropClosable' => true,
    'escClosable' => true,
    'persistent' => false,
])

@php
    $validSizes = ['sm', 'md', 'lg', 'xl', 'full'];
    if (!in_array($size, $validSizes)) {
        $size = 'md';
    }

    $sizeClasses = match($size) {
        'sm'   => 'max-w-md',
        'lg'   => 'max-w-4xl',
        'xl'   => 'max-w-6xl',
        'full' => 'w-screen h-screen max-w-none max-h-none',
        default => 'max-w-2xl',
    };

    $modalExtraClasses = $size === 'full'
        ? 'rounded-none bg-[var(--ui-surface)]'
        : 'rounded-xl bg-[var(--ui-surface)] shadow-2xl border border-[var(--ui-border)]/60';

    $canCloseByBackdrop = !$persistent && $backdropClosable;
    $canCloseByEsc = !$persistent && $escClosable;
@endphp

<div 
    x-data="{ modalShow: $wire.entangle('{{ $model }}') }"
    x-show="modalShow"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div
        class="fixed inset-0 z-[100] flex items-center justify-center p-4"
        @keydown.window.escape="{{ $canCloseByEsc ? 'modalShow = false' : '' }}"
    >
        <!-- Overlay -->
        <div 
            class="absolute inset-0 backdrop-blur-md bg-black/50 z-[90]"
            @click="{{ $canCloseByBackdrop ? 'modalShow = false' : '' }}"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <!-- Modal -->
        <div 
            class="relative z-[100] w-full {{ $sizeClasses }} {{ $modalExtraClasses }}"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            @if ($size === 'full')
                <!-- Full Screen Modal -->
                <div class="h-screen flex flex-col">
                    <!-- Header -->
                    @if (trim($header ?? ''))
                        <div class="px-6 py-4 border-b border-[var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-[var(--ui-secondary)] m-0">
                                {{ $header }}
                            </h2>
                            <button
                                @click="modalShow = false"
                                class="p-2 text-[var(--ui-muted)] hover:text-[var(--ui-danger)] hover:bg-[var(--ui-muted-5)] rounded-lg transition-colors"
                                aria-label="Schließen"
                            >
                                @svg('heroicon-o-x-mark', 'w-5 h-5')
                            </button>
                        </div>
                    @endif

                    <!-- Body -->
                    <div class="flex-1 overflow-y-auto p-6">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    @if (isset($footer))
                        <div class="px-6 py-4 border-t border-[var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            @else
                <!-- Regular Modal -->
                <div class="max-h-[90vh] flex flex-col">
                    <!-- Header -->
                    @if (trim($header ?? ''))
                        <div class="px-6 py-4 border-b border-[var(--ui-border)]/60 flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-[var(--ui-secondary)] m-0">
                                {{ $header }}
                            </h2>
                            <button
                                @click="modalShow = false"
                                class="p-2 text-[var(--ui-muted)] hover:text-[var(--ui-danger)] hover:bg-[var(--ui-muted-5)] rounded-lg transition-colors"
                                aria-label="Schließen"
                            >
                                @svg('heroicon-o-x-mark', 'w-5 h-5')
                            </button>
                        </div>
                    @endif

                    <!-- Body -->
                    <div class="flex-1 overflow-y-auto p-6">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    @if (isset($footer))
                        <div class="px-6 py-4 border-t border-[var(--ui-border)]/60 flex justify-end gap-3">
                            {{ $footer }}
                        </div>
                    @else
                        <div class="px-6 py-4 border-t border-[var(--ui-border)]/60 flex justify-end gap-3">
                            <x-ui-button variant="secondary-outline" size="sm" @click="modalShow = false">
                                Abbrechen
                            </x-ui-button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>