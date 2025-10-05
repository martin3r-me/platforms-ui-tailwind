@props([
    'variant' => 'primary',
    'size' => 'md',             // sm, md, lg
    'disabled' => false,
    'rounded' => 'md',          // none, sm, md, lg, full
    'iconOnly' => false,
    'href' => null,
])

@php
    $isOutline = str_contains($variant, '-outline');
    $baseVariant = $isOutline ? str_replace('-outline', '', $variant) : $variant;

    // Farbkonstrukte über CSS-Variablen; keine festen Farben
    $bgClass = $isOutline ? 'bg-transparent' : "bg-[rgb(var(--ui-{$baseVariant}-rgb))]";
    $textClass = $isOutline ? "text-[color:var(--ui-{$baseVariant})]" : "text-[color:var(--ui-on-{$baseVariant})]";
    $borderClass = $isOutline ? "border border-solid border-[color:rgb(var(--ui-{$baseVariant}-rgb))]" : '';
    $hoverClass = $isOutline
        ? "hover:bg-[rgb(var(--ui-{$baseVariant}-rgb))] hover:text-[color:var(--ui-on-{$baseVariant})]"
        : "hover:opacity-90";
    $focusRing = "focus:outline-none focus:ring-2 focus:ring-[color:rgba(var(--ui-{$baseVariant}-rgb),0.2)]";

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
        $sizeClass = match($size) {
            'sm' => 'h-8 text-sm px-3',
            'lg' => 'h-12 text-lg px-6',
            default => 'h-10 text-base px-4',
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