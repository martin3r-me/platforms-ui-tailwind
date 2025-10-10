@props([
    'maxWidth' => 'max-w-none',
    'padding' => 'px-3 py-8',
    'spacing' => 'space-y-8',
    'background' => 'bg-gray-50/30',
])

<div class="flex-1 overflow-y-auto {{ $background }}">
    <div class="{{ $maxWidth }} {{ $padding }} {{ $spacing }}">
        {{ $slot }}
    </div>
</div>
