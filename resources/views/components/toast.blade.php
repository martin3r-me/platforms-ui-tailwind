@props([
    'id' => null,
    'type' => 'info', 
    'title' => null,
    'message' => null,
    'progress' => false,
])

@php
    $colors = match($type) {
        'success' => 'bg-success-80 text-on-success',
        'error', 'danger' => 'bg-danger-80 text-on-danger',
        'warning' => 'bg-warning-80 text-on-warning',
        'info' => 'bg-info-80 text-on-info',
        default => 'bg-primary-80 text-on-primary'
    };
@endphp

<div 
    class="toast {{ $colors }} rounded-md shadow-md p-4 min-w-80 w-80 d-flex flex-col gap-2"
>
    <div class="d-flex justify-between items-center">
        <div>
            @if($title)
                <strong>{{ $title }}</strong>
            @endif
            @if($message)
                <div>{{ $message }}</div>
            @endif
        </div>

        {{-- Hier kommt der Slot für z. B. den Schließen-Button --}}
        {{ $slot }}
    </div>

    @if($progress)
        <div class="toast-progress-container position-relative w-full h-1 bg-black-20 rounded-full overflow-hidden mt-1">
            <div class="toast-progress position-absolute left-0 top-0 h-full bg-white opacity-60"></div>
        </div>
    @endif
</div>

<style>
.toast:hover {
    filter: brightness(1.05);
    transform: translateX(-2px);
}
</style>