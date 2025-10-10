@props([
    'title' => '',
    'width' => 'w-80', // default width when expanded
    'defaultOpen' => true,
    'storeKey' => 'sidebarOpen', // für Aktivitäten explizit "activityOpen" setzen
    'side' => 'left', // 'left' | 'right'
    'responsive' => true, // responsive behavior
])

        <div
            x-data="{
                get open(){ return Alpine?.store('page') ? Alpine.store('page')[ '{{ $storeKey }}' ] : ({{ $defaultOpen ? 'true' : 'false' }}) },
                set open(v){ 
                    if ({{ $responsive ? 'true' : 'false' }}) {
                        // Responsive: Schließe andere Sidebars wenn eine geöffnet wird
                        if (v && '{{ $side }}' === 'left') {
                            Alpine?.store('page') && (Alpine.store('page')['activityOpen'] = false);
                        } else if (v && '{{ $side }}' === 'right') {
                            Alpine?.store('page') && (Alpine.store('page')['sidebarOpen'] = false);
                        }
                    }
                    Alpine?.store('page') && (Alpine.store('page')[ '{{ $storeKey }}' ] = v) 
                },
                get isMobile() { return window.innerWidth < 768; }
            }"
            :class="open ? (
                (isMobile ? 'fixed inset-0 z-50 w-full' : `${'{{ $width }}'} `) + 
                ( '{{ $side }}' === 'right' ? ' border-l border-[var(--ui-border)]/60' : ' border-r border-[var(--ui-border)]/60')
            ) : 'w-0 border-0'"
            class="relative flex-shrink-0 h-full bg-[var(--ui-muted-5)] transition-all duration-300"
            {{ $attributes }}
        >
    <!-- Mobile Overlay -->
    <div 
        x-show="open && isMobile" 
        @click="open = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <!-- Toggle Button Area (immer sichtbar) -->
    <div class="h-full flex flex-col relative z-50">

        <!-- Collapsed Title (deaktiviert) -->

        <!-- Sidebar Content -->
        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex-1 overflow-hidden flex flex-col"
        >
                @if($title)
                    <div class="px-6 h-14 flex items-center border-b border-[var(--ui-border)]/60 bg-[var(--ui-surface)]/90 backdrop-blur">
                        <h2 class="text-sm font-semibold text-[var(--ui-secondary)] m-0 tracking-wide uppercase">{{ $title }}</h2>
                        <button 
                            type="button"
                            @click="open = false"
                            class="ml-auto inline-flex items-center justify-center rounded-md text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                            title="Sidebar schließen"
                        >
                            @svg('heroicon-o-x-mark', 'w-5 h-5')
                        </button>
                    </div>
                @endif

            <div class="flex-1 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

