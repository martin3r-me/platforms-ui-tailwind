@props([
    'title' => '',
    'width' => 'w-80', // default width when expanded
    'defaultOpen' => true,
    'storeKey' => 'sidebarOpen', // für Aktivitäten explizit "activityOpen" setzen
    'side' => 'left', // 'left' | 'right'
])

<div
    x-data
    :class="(Alpine?.store('page')?.['{{ $storeKey }}'] ?? {{ $defaultOpen ? 'true' : 'false' }}) ? (`{{ $width }} ` + ( '{{ $side }}' === 'right' ? 'border-l border-[var(--ui-border)]/60' : 'border-r border-[var(--ui-border)]/60')) : 'w-0 border-0'"
    class="relative flex-shrink-0 h-full bg-[var(--ui-muted-5)] transition-all duration-300 overflow-x-hidden"
    {{ $attributes }}
>
    <!-- Toggle Button Area (immer sichtbar) -->
    <div class="h-full flex flex-col">

        <!-- Collapsed Title (deaktiviert) -->

        <!-- Sidebar Content -->
        <div 
            x-show="Alpine?.store('page')?.['{{ $storeKey }}'] ?? {{ $defaultOpen ? 'true' : 'false' }}" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex-1 overflow-hidden overflow-x-hidden flex flex-col"
        >
                @if($title)
                    <div class="px-6 h-14 flex items-center border-b border-[var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur">
                        <h2 class="text-sm font-semibold text-[var(--ui-secondary)] m-0 tracking-wide uppercase">{{ $title }}</h2>
                        <button 
                            type="button"
                            @click="Alpine?.store('page') && (Alpine.store('page')['{{ $storeKey }}'] = false)"
                            class="ml-auto inline-flex items-center justify-center rounded-md text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                            title="Sidebar schließen"
                        >
                            @svg('heroicon-o-x-mark', 'w-5 h-5')
                        </button>
                    </div>
                @endif

            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

