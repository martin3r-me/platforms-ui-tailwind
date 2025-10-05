@props([
    'variant'    => 'primary',
    'size'       => 'md',
    'icon'       => null,
    'iconOnly'   => false,
    'counter'    => null,
    'pill'       => true,
    'as'         => 'span',
    'href'       => null,
    'class'      => '',
])

@php
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

    $variantClasses = "bg-[color:var(--ui-{$variant}-10)] text-[color:var(--ui-{$variant})] border-[color:var(--ui-{$variant}-20)]";
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
            <span class="ml-1 bg-white text-[10px] font-semibold px-2 rounded-full min-w-4 text-center leading-none">
                {{ $counter }}
            </span>
        @endif
    @endunless
</{{ $as }}>