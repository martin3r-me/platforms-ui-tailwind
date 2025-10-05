@props([
    'id' => null,
    'type' => 'info',
    'title' => null,
    'message' => null,
    'progress' => false,
])

@php
    $classes = match($type) {
        'success' => 'bg-[color:var(--ui-success-80)] text-[color:var(--ui-on-success)]',
        'error', 'danger' => 'bg-[color:var(--ui-danger-80)] text-[color:var(--ui-on-danger)]',
        'warning' => 'bg-[color:var(--ui-warning-80)] text-[color:var(--ui-on-warning)]',
        'info' => 'bg-[color:var(--ui-info-80)] text-[color:var(--ui-on-info)]',
        default => 'bg-[color:var(--ui-primary-80)] text-[color:var(--ui-on-primary)]',
    };
@endphp

<div 
    class="toast {{ $classes }} rounded-md shadow-md p-4 min-w-80 w-80 flex flex-col gap-2 hover:brightness-105 hover:-translate-x-0.5 transition"
>
    <div class="flex justify-between items-center">
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
            <div class="absolute left-0 top-0 h-full bg-white/60"></div>
        </div>
    @endif
</div>