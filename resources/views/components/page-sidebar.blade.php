@props([
    'title' => '',
    'width' => 'w-80', // default width when expanded
    'defaultOpen' => true,
])

<div 
    x-data="{ open: {{ $defaultOpen ? 'true' : 'false' }} }"
    :class="open ? '{{ $width }}' : 'w-0'"
    class="relative flex-shrink-0 h-full border-r border-[var(--ui-border)] bg-[var(--ui-surface)] transition-all duration-300 overflow-hidden"
    {{ $attributes }}
>
    <!-- Toggle Button (immer sichtbar, auch wenn sidebar zu) -->
    <button 
        @click="open = !open"
        class="absolute top-4 -right-3 z-20 w-6 h-6 rounded-full bg-[var(--ui-surface)] border border-[var(--ui-border)] shadow-sm flex items-center justify-center text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:border-[var(--ui-primary)] transition-colors"
        :title="open ? 'Sidebar schließen' : 'Sidebar öffnen'"
    >
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="w-4 h-4 transition-transform duration-300" 
            :class="{ 'rotate-180': !open }"
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Sidebar Content -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="h-full flex flex-col {{ $width }}"
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

