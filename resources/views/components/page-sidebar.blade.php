@props([
    'title' => '',
    'width' => 'w-80', // default width when expanded
    'defaultOpen' => true,
])

<div 
    x-data="{ open: Alpine?.store('page') ? Alpine.store('page').sidebarOpen : ({{ $defaultOpen ? 'true' : 'false' }}) }"
    x-init="$watch('open', v => Alpine?.store('page') && (Alpine.store('page').sidebarOpen = v))"
    :class="open ? '{{ $width }}' : 'w-0'"
    class="relative flex-shrink-0 h-full border-r border-[var(--ui-border)] bg-[var(--ui-surface)] transition-all duration-300"
    {{ $attributes }}
>
    <!-- Toggle Button Area (immer sichtbar) -->
    <div class="h-full flex flex-col">
        <button 
            @click="open = !open"
            class="flex items-center justify-center h-14 border-b border-[var(--ui-border)] text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
            :title="open ? 'Sidebar schließen' : 'Sidebar öffnen'"
        >
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="w-5 h-5 transition-transform duration-300" 
                :class="{ 'rotate-180': !open }"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>

        <!-- Collapsed Title -->
        <div x-show="!open" class="flex-1 flex items-center justify-center" x-cloak>
            @if($title)
                <div class="text-[var(--ui-muted)] text-sm font-semibold tracking-wide -rotate-90 origin-center select-none whitespace-nowrap">
                    {{ strtoupper($title) }}
                </div>
            @endif
        </div>

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
                <div class="px-4 py-3 border-b border-[var(--ui-border)] bg-[var(--ui-surface)]">
                    <h2 class="text-sm font-semibold text-[var(--ui-secondary)] m-0">{{ $title }}</h2>
                </div>
            @endif

            <div class="flex-1 overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

