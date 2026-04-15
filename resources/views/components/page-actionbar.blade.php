@props([
    'breadcrumbs' => [],
])

<div class="sticky top-12 z-30 px-4 h-11 bg-[var(--ui-surface)]/90 border-b border-[var(--ui-border)]/40 backdrop-blur">
    <div class="h-full flex items-center justify-between gap-3">
        <!-- Links: Breadcrumbs + Actions -->
        <div class="flex items-center gap-2 min-w-0">
            <x-ui-breadcrumb :items="$breadcrumbs" />
            @isset($left)
                <div class="flex items-center gap-1 ml-2 pl-2 border-l border-[var(--ui-border)]/40">
                    {{ $left }}
                </div>
            @endisset
        </div>
        <!-- Rechts: Action Buttons -->
        <div class="flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</div>
