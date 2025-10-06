@props([
    'variant' => 'primary',
    'size' => 'md',             // sm, md, lg
    'disabled' => false,
    'rounded' => 'md',          // none, sm, md, lg, full
    'iconOnly' => false,
    'href' => null,
    'useVars' => true,          // wenn false: feste Tailwind-Farben für Diagnose/Fail-Safe
    'simple' => false,          // wenn true: stark vereinfachter Stil (türkiser Button über Variablen)
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

    // Einfacher Modus: Ein einheitlicher, schöner Button auf Basis der Primärfarbe
    $isSimple = filter_var($simple, FILTER_VALIDATE_BOOLEAN);
    if ($isSimple) {
        // Flacher, variablenfreier Button (Indigo-Farben), kompatibel mit jedem Setup
        $bgClass = 'bg-indigo-600';
        $textClass = 'text-white';
        $borderClass = 'border border-transparent';
        $hoverClass = 'hover:bg-indigo-500';
        $focusRing = 'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600';
    } else {
        // Farb-Setup: wahlweise via CSS-Variablen (normal) oder feste Tailwind-Farben (Diagnose)
    $useVarsBool = filter_var($useVars, FILTER_VALIDATE_BOOLEAN);
    if ($useVarsBool) {
        if ($isOutline) {
            $bgClass = 'bg-transparent';
            $textClass = "text-[var(--ui-{$baseVariant})]";
            $borderClass = "border border-solid border-[rgb(var(--ui-{$baseVariant}-rgb))]";
            $hoverClass = "hover:bg-[rgb(var(--ui-{$baseVariant}-rgb))] hover:text-[var(--ui-on-{$baseVariant})]";
        } elseif ($isSoft) {
            $bgClass = "bg-[rgba(var(--ui-{$baseVariant}-rgb),0.10)]";
            $textClass = "text-[var(--ui-{$baseVariant})]";
            $borderClass = "border border-[rgba(var(--ui-{$baseVariant}-rgb),0.25)]";
            $hoverClass = "hover:bg-[rgba(var(--ui-{$baseVariant}-rgb),0.16)] hover:border-[rgba(var(--ui-{$baseVariant}-rgb),0.35)]";
        } elseif ($isGhost) {
            $bgClass = 'bg-transparent';
            $textClass = "text-[var(--ui-{$baseVariant})]";
            $borderClass = "border border-transparent";
            $hoverClass = "hover:bg-[rgba(var(--ui-{$baseVariant}-rgb),0.08)] hover:border-[rgba(var(--ui-{$baseVariant}-rgb),0.20)]";
        } else {
            $bgClass = "bg-[rgb(var(--ui-{$baseVariant}-rgb))]";
            $textClass = "text-[var(--ui-on-{$baseVariant})]";
            $borderClass = '';
            $hoverClass = "hover:opacity-90";
        }
        $focusRing = "focus:outline-none focus:ring-2 focus:ring-[rgba(var(--ui-{$baseVariant}-rgb),0.28)] focus:ring-offset-1 focus:ring-offset-[var(--ui-surface)]";
    } else {
        // Feste Tailwind-Farben (nur für Diagnose): Mapping ausgewählter Varianten
        $colorMap = [
            'primary' => 'indigo',
            'success' => 'emerald',
            'secondary' => 'slate',
            'info' => 'sky',
            'warning' => 'amber',
            'danger' => 'rose',
        ];
        $c = $colorMap[$baseVariant] ?? 'indigo';
        if ($isOutline) {
            $bgClass = 'bg-transparent';
            $textClass = "text-{$c}-600";
            $borderClass = "border border-{$c}-600";
            $hoverClass = "hover:bg-{$c}-600 hover:text-white";
            $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$c}-600";
        } elseif ($isSoft) {
            $bgClass = "bg-{$c}-100";
            $textClass = "text-{$c}-700";
            $borderClass = "border border-{$c}-200";
            $hoverClass = "hover:bg-{$c}-200";
            $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$c}-600";
        } elseif ($isGhost) {
            $bgClass = 'bg-transparent';
            $textClass = "text-{$c}-600";
            $borderClass = "border border-transparent";
            $hoverClass = "hover:bg-{$c}-50";
            $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$c}-600";
        } else {
            $bgClass = "bg-{$c}-600";
            $textClass = 'text-white';
            $borderClass = 'border border-transparent';
            $hoverClass = "hover:bg-{$c}-500";
            $focusRing = "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-{$c}-600";
        }
    }
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
        if ($isSimple) {
            // Größen wie im Beispiel (ohne fixe Höhe)
            $sizeClass = match($size) {
                'sm' => 'px-2.5 py-1 text-sm',
                'lg' => 'px-4 py-2.5 text-sm',
                default => 'px-3.5 py-2 text-sm', // md
            };
        } else {
            $sizeClass = match($size) {
                'sm' => 'h-8 text-sm px-3',
                'lg' => 'h-12 text-lg px-6',
                default => 'h-10 text-base px-4',
            };
        }
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