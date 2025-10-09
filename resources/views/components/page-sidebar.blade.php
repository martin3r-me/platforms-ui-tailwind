@props([
    'title' => '',
    'width' => 'w-80', // default width when expanded
    'defaultOpen' => true,
    'storeKey' => 'sidebarOpen', // für Aktivitäten explizit "activityOpen" setzen
    'side' => 'left', // 'left' | 'right'
])

        <div
            x-data="{
                get open(){ return Alpine?.store('page') ? Alpine.store('page')[ '{{ $storeKey }}' ] : ({{ $defaultOpen ? 'true' : 'false' }}) },
                set open(v){ Alpine?.store('page') && (Alpine.store('page')[ '{{ $storeKey }}' ] = v) }
            }"
            :class="open ? (`${'{{ $width }}'} ` + ( '{{ $side }}' === 'right' ? 'border-l' : 'border-r')) : 'w-0 border-0'"
            class="relative flex-shrink-0 h-full bg-white transition-all duration-300"
            :class="open ? ( '{{ $side }}' === 'right' ? 'border-l border-[var(--ui-border)]/60' : 'border-r border-[var(--ui-border)]/60' ) : ''"
            {{ $attributes }}
        >
    <!-- Toggle Button Area (immer sichtbar) -->
    <div class="h-full flex flex-col">

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
                    <div class="px-6 py-4 border-b border-[var(--ui-border)]/60 bg-[var(--ui-muted-5)]">
                        <h2 class="text-sm font-semibold text-[var(--ui-secondary)] m-0 tracking-wide uppercase">{{ $title }}</h2>
                    </div>
                @endif

            <div class="flex-1 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

