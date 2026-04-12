@props([
    'title' => '',
    'icon' => null,
    'team' => null,
])

<div class="sticky top-0 z-40 px-4 h-10 bg-[var(--ui-surface)]/80 backdrop-blur-sm border-b border-[var(--ui-border)]/30">
    <div class="h-full flex items-center gap-3">
        {{-- Links: Titel --}}
        <div class="flex items-center gap-2 min-w-0">
            <h1 class="m-0 truncate text-[color:var(--ui-secondary)] font-medium tracking-tight text-sm">
                {{ $title }}
            </h1>
            @isset($titleActions)
                <div class="flex items-center gap-2">
                    {{ $titleActions }}
                </div>
            @endisset
        </div>

        {{-- Spacer --}}
        <div class="flex-1"></div>

        {{-- Rechts: Page-spezifische Actions --}}
        @if($slot->isNotEmpty())
            <div class="flex items-center gap-1">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
