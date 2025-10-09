@props([
    'name',
    'label'         => null,
    'hint'          => null,
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
        'xs' => 'pl-2 pr-8 py-1 text-xs',
        'sm' => 'pl-3 pr-8 py-1.5 text-sm',
        'lg' => 'pl-4 pr-8 py-2 text-lg',
        'xl' => 'pl-5 pr-8 py-2.5 text-xl',
        default => 'pl-4 pr-8 py-1.5 text-base sm:text-sm/6',
    };
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

<div>
    @if($label)
        <div class="flex items-center justify-between">
            <x-ui-label 
                :text="$label" 
                :for="$name" 
                :required="$required" 
                :variant="$variant" 
                size="sm" 
                class="mb-1"
            />
            @if($hint)
                <span id="{{ $name }}-hint" class="text-sm/6 text-[color:var(--ui-muted)]">{{ $hint }}</span>
            @endif
        </div>
    @endif

    <div class="relative">
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if($hint) aria-describedby="{{ $name }}-hint" @endif
            {{ $attributes->merge(['class' => implode(' ', [
                'block w-full rounded-md bg-white text-[color:var(--ui-body-color)]',
                'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-transparent',
                "focus:outline-2 focus:-outline-offset-2 focus:outline-[color:rgb(var(--ui-{$variant}-rgb))]",
                $sizeClass,
            ])]) }}
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
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="w-4 h-4 text-[color:var(--ui-muted)]" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>