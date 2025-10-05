{{-- resources/views/components/ui/input-number.blade.php --}}
@props([
    'name',
    'label' => null,
    'value' => null,
    'variant' => 'primary',   // primary, secondary, danger, ...
    'size' => 'md',           // xs, sm, md, lg, xl
    'errorKey' => null,
    'required' => false,
    'placeholder' => null,
    'autocomplete' => null,
    'nullable' => false,
    'min' => null,
    'max' => null,
    'step' => null,
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
@endphp

<div class="form-group">
    @if($label)
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
    @endif

    <input
        type="number"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
        @if($step !== null) step="{{ $step }}" @endif
        {{ $attributes->merge([
            'class' => implode(' ', [
                'form-control',
                "border-{$variant}",
                "focus:border-{$variant}",
                $sizeClass,
            ]),
        ]) }}
    />

    @error($errorKey)
        <span class="form-error mt-1">{{ $message }}</span>
    @enderror
</div>
