@props([
    'variant' => 'primary',     // primary, success, secondary-ghost, info-ghost, primary-outline, success-outline
    'size' => 'sm',             // sm, md, lg
    'disabled' => false,
    'rounded' => 'full',        // none, sm, md, lg, full
    'iconOnly' => false,
    'href' => null,
])

@php
    // Vereinfachtes, props-basiertes Tailwind-Design ohne Variablen
    $isOutline = str_contains($variant, '-outline');
    $isGhost = str_contains($variant, '-ghost');
    $base = str_replace(['-outline','-ghost'], '', $variant);
    $color = match($base) {
        'success' => 'emerald',
        'secondary' => 'slate',
        'info' => 'sky',
        'warning' => 'amber',
        'danger' => 'rose',
        default => 'indigo', // primary
    };

    if ($isOutline) {
        $bgClass = 'bg-transparent';
        $textClass = "text-{$color}-600";
        $borderClass = "border border-{$color}-600";
        $hoverClass = "hover:bg-{$color}-600 hover:text-white";
        $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$color}-600";
    } elseif ($isGhost) {
        $bgClass = 'bg-transparent';
        $textClass = "text-{$color}-600";
        $borderClass = 'border border-transparent';
        $hoverClass = "hover:bg-{$color}-50";
        $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$color}-600";
    } else {
        $bgClass = "bg-{$color}-600";
        $textClass = 'text-white';
        $borderClass = 'border border-transparent';
        $hoverClass = "hover:bg-{$color}-500";
        $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$color}-600";
    }

    // Größen & Icon-Skalierung
    if ($iconOnly) {
        [$btnSize, $iconSize, $padding] = match($size) {
            'sm' => ['h-8 w-8', 'w-4 h-4', 'p-2'],
            'lg' => ['h-12 w-12', 'w-6 h-6', 'p-3'],
            default => ['h-10 w-10', 'w-5 h-5', 'p-2'],
        };
        $sizeClass = "$btnSize $padding";
        $roundedClass = 'rounded-full';
    } else {
        // Größen wie im Screenshot-Beispiel (ohne fixe Höhe)
        $sizeClass = match($size) {
            'sm' => 'px-2.5 py-1 text-sm',
            'lg' => 'px-4 py-2.5 text-sm',
            default => 'px-3.5 py-2 text-sm', // md
        };
        $iconSize = '';
        $roundedClass = $rounded === 'none' ? 'rounded-none' : "rounded-{$rounded}";
    }

    $classes = implode(' ', array_filter([
        'inline-flex items-center justify-center select-none whitespace-nowrap',
        'transition-colors duration-200',
        $bgClass,
        $borderClass,
        $textClass,
        $hoverClass,
        $focusRing,
        $roundedClass,
        $sizeClass,
        $disabled ? 'opacity-60 pointer-events-none' : '',
    ]));
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)>
        <span class="flex items-center justify-center">
            {{ $iconOnly ? $slot->withAttributes(['class' => trim(($slot->attributes['class'] ?? '') . ' ' . $iconSize)]) : $slot }}
        </span>
    </a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)>
        <span class="flex items-center justify-center">
            {{ $iconOnly ? $slot->withAttributes(['class' => trim(($slot->attributes['class'] ?? '') . ' ' . $iconSize)]) : $slot }}
        </span>
    </button>
@endif