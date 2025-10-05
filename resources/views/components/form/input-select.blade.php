@props([
    'name',
    'label'         => null,
    'options'       => [],
    'nullable'      => false,
    'nullLabel'     => '– Kein Wert –',
    'variant'       => 'primary',
    'size'          => 'md',
    'errorKey'      => null,
    'required'      => false,
    'disabled'      => false,
    'autocomplete'  => null,
    'optionValue'   => 'value',
    'optionLabel'   => 'label',
    'value'         => null,
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'input-xs',
        'sm' => 'input-sm',
        'lg' => 'input-lg',
        'xl' => 'input-xl',
        default => '',
    };
    $variantClass = "border-{$variant} focus:border-{$variant}";

    // Optionen normalisieren
    $normalized = [];

    if ($options instanceof \Illuminate\Support\Collection) {
        foreach ($options as $item) {
            $optValue = data_get($item, $optionValue);
            $optLabel = data_get($item, $optionLabel);
            if (is_object($item) && method_exists($item, $optionLabel)) {
                $optLabel = $item->{$optionLabel}();
            }
            $normalized[$optValue] = $optLabel;
        }
    }
    elseif (is_array($options) && !empty($options) && is_object(reset($options))) {
        foreach ($options as $enumOption) {
            $optLabel = method_exists($enumOption, $optionLabel)
                ? $enumOption->{$optionLabel}()
                : data_get($enumOption, $optionLabel);
            $optValue = data_get($enumOption, $optionValue);
            $normalized[$optValue] = $optLabel;
        }
    } else {
        $normalized = $options;
    }

    $selected = old($name, $value ?? $attributes->get('value'));
@endphp

<div class="form-group">
    @if($label)
        <x-ui-label 
            :text="$label" 
            :for="$name" 
            :required="$required" 
            :variant="$variant" 
            size="sm" 
            class="mb-1"
        />
    @endif

    <div class="position-relative">
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            {{ $attributes->merge([
                'class' => implode(' ', [
                    'form-control',
                    $sizeClass,
                    $variantClass,
                    'pr-8', // Platz rechts für das Icon!
                ])
            ]) }}
        >
            @if($nullable)
                <option value="">{{ $nullLabel }}</option>
            @endif
            @foreach($normalized as $optionKey => $optionLabelNormalized)
                <option value="{{ $optionKey }}" @selected($selected == $optionKey)>
                    {{ $optionLabelNormalized }}
                </option>
            @endforeach
        </select>
        {{-- Dropdown-Icon --}}
        <div class="position-absolute top-0 right-0 h-full d-flex items-center pr-3 pointer-events-none">
            {{-- Heroicon oder SVG --}}
            <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
            {{-- Alternativ: <x-heroicon-m-chevron-down class="w-4 h-4 text-muted" /> --}}
        </div>
    </div>

    @error($errorKey)
        <span class="form-error mt-1">{{ $message }}</span>
    @enderror
</div>