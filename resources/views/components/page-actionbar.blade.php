@props([
    'breadcrumbs' => [],
])

<div class="sticky top-14 z-30 px-4 h-11 bg-[var(--ui-surface)]/90 border-b border-[var(--ui-border)]/40 backdrop-blur">
    <div class="h-full flex items-center justify-between gap-3">
        <!-- Links: Breadcrumbs -->
        <div class="flex items-center min-w-0">
            <x-ui-breadcrumb :items="$breadcrumbs" />
        </div>
        <!-- Rechts: Action Buttons -->
        <div class="flex items-center gap-2">
            {{ $slot }}
        </div>
    </div>
</div>
