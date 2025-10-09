@props([
    'maxWidth' => 'max-w-7xl',
    'padding' => 'px-8 py-8',
    'spacing' => 'space-y-8',
    'background' => 'bg-gray-50/30',
])

<div class="flex-1 overflow-y-auto {{ $background }}">
    <div class="{{ $maxWidth }} mx-auto {{ $padding }} {{ $spacing }}">
        {{ $slot }}
    </div>
</div>
