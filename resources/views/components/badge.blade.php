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
        'xs' => 'text-xs px-1.5 py-0.5',
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-sm px-2.5 py-1',
        'lg' => 'text-sm px-3 py-1',
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
        @if(str_starts_with($icon, 'heroicon-'))
            <x-dynamic-component :component="$icon" :class="$iconSize" />
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