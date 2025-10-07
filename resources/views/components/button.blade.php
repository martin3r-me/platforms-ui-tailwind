@props([
    'variant' => 'primary',     // primary, success, secondary, info, warning, danger (+ -outline | -ghost)
    'size' => 'sm',             // sm, md, lg
    'disabled' => false,
    'rounded' => 'full',        // none, sm, md, lg, full
    'iconOnly' => false,
    'href' => null,
])

@php
    // Varianten via CSS-Variablen (Tailwind Arbitrary Values)
    $isOutline = str_contains($variant, '-outline');
    $isGhost = str_contains($variant, '-ghost');
    $base = str_replace(['-outline','-ghost'], '', $variant);
    $allowed = in_array($base, ['primary','success','secondary','info','warning','danger','muted']) ? $base : 'primary';

    if ($isOutline) {
        $variantClasses = implode(' ', [
            'bg-transparent',
            "text-[var(--ui-{$allowed})]",
            "border border-[rgb(var(--ui-{$allowed}-rgb))]",
            "hover:bg-[rgb(var(--ui-{$allowed}-rgb))] hover:text-[var(--ui-on-{$allowed})]",
            "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[rgb(var(--ui-{$allowed}-rgb))]",
        ]);
    } elseif ($isGhost) {
        $variantClasses = implode(' ', [
            'bg-transparent',
            "text-[var(--ui-{$allowed})]",
            'border border-transparent',
            "hover:bg-[rgba(var(--ui-{$allowed}-rgb),0.08)]",
            "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[rgb(var(--ui-{$allowed}-rgb))]",
        ]);
    } else {
        $variantClasses = implode(' ', [
            "bg-[rgb(var(--ui-{$allowed}-rgb))]",
            "text-[var(--ui-on-{$allowed})]",
            'border border-transparent',
            'hover:opacity-90',
            "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[rgb(var(--ui-{$allowed}-rgb))]",
        ]);
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
            default => 'px-3.5 py-2 text-sm',
        };
        $iconSize = '';
        $roundedClass = $rounded === 'none' ? 'rounded-none' : "rounded-{$rounded}";
    }

    $classes = implode(' ', array_filter([
        'inline-flex items-center justify-center select-none whitespace-nowrap',
        'transition-colors duration-200',
        $variantClasses,
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