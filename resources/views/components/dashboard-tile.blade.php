@props([
    'title' => '',
    'count' => 0,
    'icon' => 'question-mark-circle',
    'route' => null,
    'size' => 'md',
    'variant' => 'primary',
    'trend' => null,
    'trendValue' => null,
    'description' => null,
    'loading' => false,
    'clickable' => false,
    'href' => null,
    'target' => '_self',
    'animate' => false,
])

@php
    $sizeClasses = match($size) {
        'sm' => [
            'container' => 'p-4',
            'title' => 'text-sm font-medium',
            'count' => 'text-2xl font-bold',
            'icon' => 'w-6 h-6',
            'description' => 'text-xs',
            'trend' => 'text-xs',
        ],
        'lg' => [
            'container' => 'p-8',
            'title' => 'text-xl font-semibold',
            'count' => 'text-4xl font-bold',
            'icon' => 'w-12 h-12',
            'description' => 'text-base',
            'trend' => 'text-sm',
        ],
        default => [
            'container' => 'p-6',
            'title' => 'text-lg font-semibold',
            'count' => 'text-3xl font-bold',
            'icon' => 'w-8 h-8',
            'description' => 'text-sm',
            'trend' => 'text-sm',
        ],
    };

    $variantClasses = [
        'bg' => "bg-[color:var(--ui-{$variant}-5)]",
        'border' => "border-[color:var(--ui-{$variant}-20)]",
        'text' => "text-[color:var(--ui-{$variant})]",
        'hover' => "hover:bg-[color:var(--ui-{$variant}-10)]",
        'icon' => "text-[color:var(--ui-{$variant})]",
        'count' => "text-[color:var(--ui-{$variant})]",
    ];

    $trendClasses = match($trend) {
        'up' => 'text-[color:var(--ui-success)]',
        'down' => 'text-[color:var(--ui-danger)]',
        default => 'text-[color:var(--ui-muted)]',
    };

    $trendIcon = match($trend) {
        'up' => 'heroicon-o-arrow-trending-up',
        'down' => 'heroicon-o-arrow-trending-down',
        default => null,
    };

    $linkUrl = $href ?: $route;
    $isClickable = $clickable || $linkUrl;

    $containerClasses = implode(' ', [
        'bg-[color:var(--ui-surface)] rounded-lg border transition-all duration-200',
        $sizeClasses['container'],
        $variantClasses['bg'],
        $variantClasses['border'],
        $isClickable ? 'cursor-pointer' : '',
        $isClickable ? $variantClasses['hover'] : '',
        $isClickable ? 'hover:shadow-lg hover:scale-[1.02]' : 'hover:shadow-md',
        $loading ? 'opacity-75' : '',
        $animate ? 'animate-pulse' : '',
    ]);
@endphp

@if($isClickable && $linkUrl)
    <a href="{{ $linkUrl }}" target="{{ $target }}" class="block">
@endif

<div {{ $attributes->merge(['class' => $containerClasses]) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1 min-w-0">
            <h3 class="{{ $sizeClasses['title'] }} text-[color:var(--ui-secondary)] mb-2">{{ $title }}</h3>
            @if($loading)
                <div class="flex items-center gap-2">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-current border-t-transparent {{ $variantClasses['text'] }}"></div>
                    <span class="{{ $sizeClasses['count'] }} {{ $variantClasses['count'] }}">Lädt...</span>
                </div>
            @else
                <p class="{{ $sizeClasses['count'] }} {{ $variantClasses['count'] }} mb-1">{{ number_format($count) }}</p>
            @endif
            @if($description)
                <p class="{{ $sizeClasses['description'] }} text-[color:var(--ui-muted)] mb-2">{{ $description }}</p>
            @endif
            @if($trend && $trendValue)
                <div class="flex items-center gap-1 {{ $sizeClasses['trend'] }} {{ $trendClasses }}">
                    @if($trendIcon)
                        <x-dynamic-component :component="$trendIcon" class="w-4 h-4" />
                    @endif
                    <span>{{ $trendValue }}</span>
                </div>
            @endif
        </div>
        <div class="shrink-0 ml-4">
            <div class="{{ $variantClasses['icon'] }}">
                <x-dynamic-component :component="'heroicon-o-' . $icon" :class="$sizeClasses['icon']" />
            </div>
        </div>
    </div>
    @if($route && !$isClickable)
        <div class="mt-4">
            <x-ui-button variant="{{ $variant }}" size="{{ $size === 'sm' ? 'xs' : 'sm' }}" href="{{ $route }}">
                Anzeigen
            </x-ui-button>
        </div>
    @endif
</div>

@if($isClickable && $linkUrl)
    </a>
@endif 