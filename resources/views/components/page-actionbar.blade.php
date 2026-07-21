{{-- nx: ruhige Actionbar — warmer Grund, Hairline statt Border (übergleich) --}}
@props([
    'breadcrumbs' => [],
])

<div class="shrink-0 z-30 px-4 h-11 bg-[color:var(--nx-surface)] border-b border-[color:var(--nx-line)]">
    <div class="h-full flex items-center gap-3">
        <!-- Links: Breadcrumbs + Actions (flexibel, schrumpft/kürzt) -->
        <div class="flex items-center gap-2 min-w-0 flex-1">
            <x-ui-breadcrumb :items="$breadcrumbs" />
            @isset($left)
                <div class="flex items-center gap-1 ml-2 pl-2 border-l border-[color:var(--nx-line)] shrink-0">
                    {{ $left }}
                </div>
            @endisset
        </div>
        <!-- Rechts: Action Buttons (fix, kein Schrumpfen) -->
        <div class="flex items-center gap-2 shrink-0">
            {{ $slot }}
        </div>
    </div>
</div>
