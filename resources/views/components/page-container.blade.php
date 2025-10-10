@props([
    'padding' => 'p-5',
    'spacing' => 'space-y-8',
    'background' => 'bg-gray-50/30',
])

<div class="flex-1 overflow-y-auto {{ $background }}">
    <div class="{{ $padding }} {{ $spacing }}">
        {{ $slot }}
    </div>
</div>
