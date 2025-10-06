@props([
    'variant' => 'primary',
    'size' => 'md',             // sm, md, lg
    'disabled' => false,
    'rounded' => 'md',          // none, sm, md, lg, full
    'iconOnly' => false,
    'href' => null,
])

@php
    // Varianten erkennen: solid (default), outline, soft, ghost
    $isOutline = str_contains($variant, '-outline');
    $isSoft = str_contains($variant, '-soft');
    $isGhost = str_contains($variant, '-ghost');
    $baseVariant = $variant;
    foreach (['-outline', '-soft', '-ghost'] as $suffix) {
        if (str_contains($baseVariant, $suffix)) {
            $baseVariant = str_replace($suffix, '', $baseVariant);
        }
    }

    // Farbkonstrukte über CSS-Variablen; korrekte Tailwind Arbitrary Values
    if ($isOutline) {
        $bgClass = 'bg-transparent';
        $textClass = "text-[var(--ui-{$baseVariant})]";
        $borderClass = "border border-solid border-[rgb(var(--ui-{$baseVariant}-rgb))]";
        $hoverClass = "hover:bg-[rgb(var(--ui-{$baseVariant}-rgb))] hover:text-[var(--ui-on-{$baseVariant})]";
    } elseif ($isSoft) {
        $bgClass = "bg-[rgba(var(--ui-{$baseVariant}-rgb),0.1)]";
        $textClass = "text-[var(--ui-{$baseVariant})]";
        $borderClass = "border border-transparent";
        $hoverClass = "hover:bg-[rgba(var(--ui-{$baseVariant}-rgb),0.18)]";
    } elseif ($isGhost) {
        $bgClass = 'bg-transparent';
        $textClass = "text-[var(--ui-{$baseVariant})]";
        $borderClass = "border border-transparent";
        $hoverClass = "hover:bg-[rgba(var(--ui-{$baseVariant}-rgb),0.08)]";
    } else {
        // solid
        $bgClass = "bg-[rgb(var(--ui-{$baseVariant}-rgb))]";
        $textClass = "text-[var(--ui-on-{$baseVariant})]";
        $borderClass = '';
        $hoverClass = "hover:opacity-90";
    }
    $focusRing = "focus:outline-none focus:ring-2 focus:ring-[rgba(var(--ui-{$baseVariant}-rgb),0.28)] focus:ring-offset-1 focus:ring-offset-[var(--ui-surface)]";

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