@props([
    'id' => null,
    'type' => 'info',
    'title' => null,
    'message' => null,
    'progress' => false,
    'duration' => 5000,
])

@php
    $classes = match($type) {
        'success' => 'bg-[color:var(--ui-success-80)] text-[color:var(--ui-on-success)]',
        'error', 'danger' => 'bg-[color:var(--ui-danger-80)] text-[color:var(--ui-on-danger)]',
        'warning' => 'bg-[color:var(--ui-warning-80)] text-[color:var(--ui-on-warning)]',
        'info' => 'bg-[color:var(--ui-info-80)] text-[color:var(--ui-on-info)]',
        default => 'bg-[color:var(--ui-primary-80)] text-[color:var(--ui-on-primary)]',
    };

    $iconName = match($type) {
        'success' => 'heroicon-o-check-circle',
        'error', 'danger' => 'heroicon-o-x-circle',
        'warning' => 'heroicon-o-exclamation-triangle',
        'info' => 'heroicon-o-information-circle',
        default => 'heroicon-o-information-circle',
    };
@endphp

<div
    class="toast {{ $classes }} rounded-lg shadow-lg p-4 min-w-80 w-80 flex flex-col gap-2 hover:brightness-105 hover:-translate-x-0.5 transition relative"
    x-data="{ show: true }"
>
    {{-- Close button --}}
    <button
        @click="show = false; $el.closest('.toast').remove()"
        class="absolute top-2 right-2 opacity-70 hover:opacity-100 transition-opacity"
        aria-label="Schließen"
    >
        @svg('heroicon-o-x-mark', 'w-4 h-4')
    </button>

    <div class="flex items-start gap-3 pr-4">
        <div class="shrink-0 mt-0.5">
            @svg($iconName, 'w-5 h-5')
        </div>
        <div>
            @if($title)
                <strong>{{ $title }}</strong>
            @endif
            @if($message)
                <div>{{ $message }}</div>
            @endif
        </div>

        {{ $slot }}
    </div>

    @if($progress)
        <div class="relative w-full h-1 bg-black/20 rounded-full overflow-hidden mt-1">
            <div
                class="absolute left-0 top-0 h-full bg-white/60 rounded-full"
                style="animation: toast-countdown {{ $duration }}ms linear forwards"
            ></div>
        </div>
        <style>
            @keyframes toast-countdown {
                from { width: 100%; }
                to { width: 0%; }
            }
        </style>
    @endif
</div>
