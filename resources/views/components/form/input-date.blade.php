@props([
    'name',
    'label' => null,
    'value' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'required' => false,
    'placeholder' => null,
    'autocomplete' => null,
    'nullable' => true,
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'h-8 text-xs px-2',
        'sm' => 'h-9 text-sm px-3',
        'lg' => 'h-11 text-lg px-4',
        'xl' => 'h-12 text-xl px-5',
        default => 'h-10 text-base px-4',
    };
    $baseClasses = [
        'block w-full rounded-md bg-white text-[color:var(--ui-body-color)] placeholder-gray-400',
        'border border-[color:var(--ui-border)]',
        "focus:outline-none focus:ring-2 focus:ring-[color:rgba(var(--ui-{$variant}-rgb),0.2)] focus:border-[color:rgb(var(--ui-{$variant}-rgb))]",
        $sizeClass,
    ];
    
    // Format value for date input (YYYY-MM-DD)
    $formattedValue = null;
    if ($value) {
        if (is_string($value)) {
            try {
                // Prüfe ob es nur ein Jahr ist (z.B. "2025")
                if (preg_match('/^\d{4}$/', $value)) {
                    $formattedValue = null; // Ungültiges Format ignorieren
                } else {
                    $date = \Carbon\Carbon::parse($value);
                    $formattedValue = $date->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $formattedValue = null;
            }
        } elseif ($value instanceof \Carbon\Carbon) {
            $formattedValue = $value->format('Y-m-d');
        }
    }
@endphp

<div>
    @if($label)
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
    @endif

    <div class="relative">
        <input
            type="date"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $formattedValue) }}"
            @if($required) required @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            {{ $attributes->merge(['class' => implode(' ', $baseClasses)]) }}
        />
        
        @if($nullable && $formattedValue)
            <button
                type="button"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                onclick="document.getElementById('{{ $name }}').value = ''; document.getElementById('{{ $name }}').dispatchEvent(new Event('input'));"
                title="Datum löschen"
            >
                @svg('heroicon-o-x-mark', 'w-4 h-4')
            </button>
        @endif
    </div>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>