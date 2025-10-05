{{-- resources/views/components/ui/textarea.blade.php --}}
@props([
    'name',
    'label' => null,
    'value' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'rows' => 4,
    'required' => false,
    'placeholder' => null,
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

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge([
            'class' => implode(' ', [
                'form-control',
                "border-{$variant}",
                "focus:border-{$variant}",
                $sizeClass,
            ]),
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @error($errorKey)
        <span class="form-error mt-1">{{ $message }}</span>
    @enderror
</div>