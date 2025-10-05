@props([
    'title' => '',
    'count' => 0,
    'icon' => 'question-mark-circle',
    'route' => null,
    'size' => 'md',              // sm, md, lg
    'variant' => 'primary',      // primary, secondary, success, danger, warning, info, neutral
    'trend' => null,             // 'up', 'down', null
    'trendValue' => null,        // z.B. '+12%', '-5%'
    'description' => null,       // Zusätzliche Beschreibung
    'loading' => false,          // Loading State
    'clickable' => false,        // Ganzes Tile klickbar machen
    'href' => null,              // Alternative zu route
    'target' => '_self',         // _self, _blank, etc.
    'animate' => false,          // Animation beim Laden
])

@php
    // Größenklassen
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

    // Farbvarianten mit CSS-Variablen
    $variantClasses = match($variant) {
        'primary' => [
            'bg' => 'bg-primary-5',
            'border' => 'border-primary-20',
            'text' => 'text-primary',
            'hover' => 'hover:bg-primary-10',
            'icon' => 'text-primary',
            'count' => 'text-primary',
        ],
        'secondary' => [
            'bg' => 'bg-secondary-5',
            'border' => 'border-secondary-20',
            'text' => 'text-secondary',
            'hover' => 'hover:bg-secondary-10',
            'icon' => 'text-secondary',
            'count' => 'text-secondary',
        ],
        'success' => [
            'bg' => 'bg-success-5',
            'border' => 'border-success-20',
            'text' => 'text-success',
            'hover' => 'hover:bg-success-10',
            'icon' => 'text-success',
            'count' => 'text-success',
        ],
        'danger' => [
            'bg' => 'bg-danger-5',
            'border' => 'border-danger-20',
            'text' => 'text-danger',
            'hover' => 'hover:bg-danger-10',
            'icon' => 'text-danger',
            'count' => 'text-danger',
        ],
        'warning' => [
            'bg' => 'bg-warning-5',
            'border' => 'border-warning-20',
            'text' => 'text-warning',
            'hover' => 'hover:bg-warning-10',
            'icon' => 'text-warning',
            'count' => 'text-warning',
        ],
        'info' => [
            'bg' => 'bg-info-5',
            'border' => 'border-info-20',
            'text' => 'text-info',
            'hover' => 'hover:bg-info-10',
            'icon' => 'text-info',
            'count' => 'text-info',
        ],
        'neutral' => [
            'bg' => 'bg-muted-5',
            'border' => 'border-muted-20',
            'text' => 'text-muted',
            'hover' => 'hover:bg-muted-10',
            'icon' => 'text-muted',
            'count' => 'text-muted',
        ],
        default => [
            'bg' => 'bg-primary-5',
            'border' => 'border-primary-20',
            'text' => 'text-primary',
            'hover' => 'hover:bg-primary-10',
            'icon' => 'text-primary',
            'count' => 'text-primary',
        ],
    };

    // Trend-Klassen
    $trendClasses = match($trend) {
        'up' => 'text-success',
        'down' => 'text-danger',
        default => 'text-muted',
    };

    $trendIcon = match($trend) {
        'up' => 'heroicon-o-arrow-trending-up',
        'down' => 'heroicon-o-arrow-trending-down',
        default => null,
    };

    // Link-URL bestimmen
    $linkUrl = $href ?: $route;
    $isClickable = $clickable || $linkUrl;

    // Container-Klassen
    $containerClasses = implode(' ', [
        'bg-surface rounded-lg border transition-all duration-200',
        $sizeClasses['container'],
        $variantClasses['bg'],
        $variantClasses['border'],
        $isClickable ? 'cursor-pointer' : '',
        $isClickable ? $variantClasses['hover'] : '',
        $isClickable ? 'hover:shadow-lg hover:scale-105' : 'hover:shadow-md',
        $loading ? 'opacity-75' : '',
        $animate ? 'animate-pulse' : '',
    ]);
@endphp

@if($isClickable && $linkUrl)
    <a href="{{ $linkUrl }}" target="{{ $target }}" class="block">
@endif

<div {{ $attributes->merge(['class' => $containerClasses]) }}>
    <div class="d-flex items-center justify-between">
        <div class="flex-grow-1 min-w-0">
            <h3 class="{{ $sizeClasses['title'] }} text-secondary mb-2">{{ $title }}</h3>
            
            @if($loading)
                <div class="d-flex items-center gap-2">
                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-current border-t-transparent {{ $variantClasses['text'] }}"></div>
                    <span class="{{ $sizeClasses['count'] }} {{ $variantClasses['count'] }}">Lädt...</span>
                </div>
            @else
                <p class="{{ $sizeClasses['count'] }} {{ $variantClasses['count'] }} mb-1">{{ number_format($count) }}</p>
            @endif

            @if($description)
                <p class="{{ $sizeClasses['description'] }} text-muted mb-2">{{ $description }}</p>
            @endif

            @if($trend && $trendValue)
                <div class="d-flex items-center gap-1 {{ $sizeClasses['trend'] }} {{ $trendClasses }}">
                    @if($trendIcon)
                        <x-dynamic-component :component="$trendIcon" class="w-4 h-4" />
                    @endif
                    <span>{{ $trendValue }}</span>
                </div>
            @endif
        </div>

        <div class="flex-shrink-0 ml-4">
            <div class="{{ $variantClasses['icon'] }} transition-transform duration-200 {{ $isClickable ? 'group-hover:scale-110' : '' }}">
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