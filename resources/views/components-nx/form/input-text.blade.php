{{--
    nx-input-text — Textfeld mit Label/Hint/Fehler. type deckt text/email/time/password …
    <x-nx-input-text name="x" label="Name" wire:model="x" required />
--}}
@props([
    'name' => null,
    'label' => null,
    'hint' => null,
    'value' => null,
    'size' => 'md',
    'errorKey' => null,
    'type' => 'text',
    'required' => false,
    'placeholder' => null,
])

@php
    $errorKey = $errorKey ?: $name;
    $hasError = $errorKey ? $errors->has($errorKey) : false;
    $sizeClass = $size === 'sm' ? 'px-2.5 py-1.5 text-sm' : 'px-3 py-2 text-sm';
@endphp

<div>
    @if ($label)
        <div class="mb-1 flex items-center justify-between gap-2">
            <label @if ($name) for="{{ $name }}" @endif class="text-xs font-medium text-[color:var(--nx-text)]">
                {{ $label }}@if ($required)<span class="text-[color:var(--nx-danger)]"> *</span>@endif
            </label>
            @if ($hint)<span class="text-xs text-[color:var(--nx-muted)]">{{ $hint }}</span>@endif
        </div>
    @endif
    <input type="{{ $type }}"
        @if ($name) id="{{ $name }}" name="{{ $name }}" @endif
        value="{{ $name ? old($name, $value) : $value }}"
        @if ($required) required @endif
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->class([
            'block w-full rounded-[6px] border bg-[color:var(--nx-surface)] text-[color:var(--nx-text)] placeholder-[color:var(--nx-faint)] transition-colors focus:outline-none focus:ring-1',
            'border-[color:var(--nx-line-strong)] focus:border-[color:var(--nx-accent)] focus:ring-[color:var(--nx-accent)]' => ! $hasError,
            'border-[color:var(--nx-danger)] focus:ring-[color:var(--nx-danger)]' => $hasError,
            $sizeClass,
        ]) }} />
    @error($errorKey)
        <p class="mt-1 text-xs text-[color:var(--nx-danger)]">{{ $message }}</p>
    @enderror
</div>
