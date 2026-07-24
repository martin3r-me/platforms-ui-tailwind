{{--
    nx-input-select — schlichtes natives Select mit Label/Fehler.
    options: Liste aus ['value'=>…, 'label'=>…] (Schlüssel via optionValue/optionLabel).
    <x-nx-input-select name="x" label="Status" :options="[...]" nullable nullLabel="Alle" wire:model="x" />
--}}
@props([
    'name' => null,
    'label' => null,
    'hint' => null,
    'options' => [],
    'nullable' => false,
    'nullLabel' => '–',
    'size' => 'md',
    'errorKey' => null,
    'required' => false,
    'disabled' => false,
    'optionValue' => 'value',
    'optionLabel' => 'label',
    'value' => null,
])

@php
    $errorKey = $errorKey ?: $name;
    $hasError = $errorKey ? $errors->has($errorKey) : false;
    $sizeClass = $size === 'sm' ? 'px-2.5 py-1.5 text-sm' : 'px-3 py-2 text-sm';
    $current = $name ? old($name, $value) : $value;
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
    <div class="relative">
        <select
            @if ($name) id="{{ $name }}" name="{{ $name }}" @endif
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            {{ $attributes->class([
                'block w-full appearance-none rounded-[6px] border bg-[color:var(--nx-surface)] text-[color:var(--nx-text)] transition-colors focus:outline-none focus:ring-1 disabled:opacity-50',
                'border-[color:var(--nx-line-strong)] focus:border-[color:var(--nx-accent)] focus:ring-[color:var(--nx-accent)]' => ! $hasError,
                'border-[color:var(--nx-danger)] focus:ring-[color:var(--nx-danger)]' => $hasError,
                $sizeClass,
                'pr-9',
            ]) }}>
            @if ($nullable)
                <option value="">{{ $nullLabel }}</option>
            @endif
            @foreach ($options as $key => $opt)
                @php
                    // Optionen können Arrays, Eloquent-Models/Objekte, assoziative
                    // Arrays (['owner' => 'Owner']) ODER Skalare sein.
                    if (is_array($opt) || is_object($opt)) {
                        $ov = data_get($opt, $optionValue);
                        $ol = data_get($opt, $optionLabel) ?? $ov;
                    } elseif (is_string($key)) {
                        $ov = $key;
                        $ol = $opt;
                    } else {
                        $ov = $ol = $opt;
                    }
                @endphp
                <option value="{{ $ov }}" @selected((string) $current === (string) $ov)>{{ $ol }}</option>
            @endforeach
        </select>
        {{-- eigener nx-Chevron statt nativem OS-Pfeil --}}
        <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[color:var(--nx-muted)]" viewBox="0 0 20 20" fill="none" aria-hidden="true">
            <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    @error($errorKey)
        <p class="mt-1 text-xs text-[color:var(--nx-danger)]">{{ $message }}</p>
    @enderror
</div>
