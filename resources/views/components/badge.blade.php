@props([
    'variant'    => 'primary',      // Farbe
    'size'       => 'md',           // xs, sm, md, lg
    'icon'       => null,           // Icon-Component/Slot
    'iconOnly'   => false,          // true = nur Icon, kein Text
    'counter'    => null,           // Counter-Zahl oder null
    'pill'       => true,           // Pill-Shape oder square
    'as'         => 'span',         // z.B. 'a' oder 'button' oder 'span'
    'href'       => null,           // Wenn as='a'
    'class'      => '',
])



@php
    // Größenklassen für Text und Padding
    $sizeClasses = [
        'xs' => 'text-xs px-2 py-1',
        'sm' => 'text-sm px-3 py-1',
        'md' => 'text-base px-4 py-2',
        'lg' => 'text-lg px-5 py-2',
    ];
    $iconSize = [
        'xs' => 'w-3 h-3',
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
    ][$size] ?? 'w-4 h-4';

    // Farbvarianten (Tailwind-like oder eigene CSS)
    $variantClasses = [
        'primary'   => 'bg-primary-10 text-primary border-primary-20',
        'secondary' => 'bg-secondary-10 text-secondary border-secondary-20',
        'success'   => 'bg-success-10 text-success border-success-20',
        'danger'    => 'bg-danger-10 text-danger border-danger-20',
        'warning'   => 'bg-warning-10 text-warning border-warning-20',
        'info'      => 'bg-info-10 text-info border-info-20',
        'neutral'   => 'bg-muted-10 text-muted border-muted-20',
    ][$variant] ?? 'bg-primary-10 text-primary border-primary-20';

    $rounded = $pill ? 'rounded-full' : 'rounded-md';
    $base = implode(' ', [
        'inline-flex items-center gap-2 border font-medium select-none',
        $sizeClasses[$size] ?? $sizeClasses['md'],
        $variantClasses,
        $rounded,
        $iconOnly ? 'justify-center' : '',
        $class
    ]);
@endphp

<{{ $as }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => $base]) }}
>
    @if(isset($icon))
        @if($icon === 'heroicon-o-check-circle')
            <x-heroicon-o-check-circle :class="$iconSize" />
        @elseif($icon === 'heroicon-o-play-circle')
            <x-heroicon-o-play-circle :class="$iconSize" />
        @elseif($icon === 'heroicon-o-clock')
            <x-heroicon-o-clock :class="$iconSize" />
        @else
            <span class="inline-flex {{ $iconSize }} items-center justify-center">
                {{ $icon }}
            </span>
        @endif
    @endif

    @unless($iconOnly)
        <span>{{ $slot }}</span>
        @if($counter !== null)
            <span class="ml-1 bg-white text-xxs font-semibold px-2 rounded-full min-w-4 text-center leading-none">
                {{ $counter }}
            </span>
        @endif
    @endunless
</{{ $as }}>