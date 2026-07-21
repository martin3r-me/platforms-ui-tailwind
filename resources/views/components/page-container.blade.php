{{-- nx: warmes Off-White als Content-Grund, warmer Near-Black-Text (übergleich) --}}
@props([
    'padding' => 'px-5 pb-5',
    'spacing' => 'space-y-8',
    'background' => 'bg-[color:var(--nx-surface)]',
])

<div class="flex-1 overflow-y-auto overflow-x-hidden {{ $background }} text-[color:var(--nx-text)]">
    <div class="{{ $padding }} {{ $spacing }}">
        {{ $slot }}
    </div>
</div>
