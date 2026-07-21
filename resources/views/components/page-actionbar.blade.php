{{-- nx: ruhige Actionbar — warmer Grund, Hairline statt Border (übergleich) --}}
@props([
    'breadcrumbs' => [],
])

<div class="sticky top-12 z-30 px-4 h-11 bg-[color:var(--nx-surface)] border-b border-[color:var(--nx-line)]">
    <div class="h-full flex items-center justify-between gap-3">
        <!-- Links: Breadcrumbs + Actions -->
        <div class="flex items-center gap-2 min-w-0">
            <x-ui-breadcrumb :items="$breadcrumbs" />
            @isset($left)
                <div class="flex items-center gap-1 ml-2 pl-2 border-l border-[color:var(--nx-line)]">
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
