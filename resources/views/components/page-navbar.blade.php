@props([
    'title' => '',
    'icon' => null,
])

<div class="sticky top-0 z-10 px-4 h-14 bg-[var(--ui-surface)]/90 border-b border-[var(--ui-border)]/60 backdrop-blur">
    <div class="h-full flex items-center justify-between gap-3">
        {{-- Titel-Bereich (links) --}}
        <div class="flex items-center gap-2 min-w-0">
            @if($icon)
                @svg($icon, 'w-5 h-5 text-[color:var(--ui-primary)]')
            @endif
            <h1 class="m-0 truncate text-[color:var(--ui-secondary)] font-semibold tracking-tight text-base md:text-lg">
                {{ $title }}
            </h1>
        </div>
        
        {{-- Aktionen-Bereich (rechts) --}}
        <div class="d-flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</div>

