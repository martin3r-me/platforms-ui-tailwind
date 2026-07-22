{{--
    nx-input-checkbox — Checkbox mit Label. wire:model via $attributes.
    <x-nx-input-checkbox label="Verfügbar" wire:model="available" />
--}}
@props([
    'name' => null,
    'label' => null,
    'disabled' => false,
])

<label class="inline-flex items-center gap-2 text-sm text-[color:var(--nx-text)] {{ $disabled ? 'opacity-50' : 'cursor-pointer' }}">
    <input type="checkbox" value="1"
        @if ($name) id="{{ $name }}" name="{{ $name }}" @endif
        @if ($disabled) disabled @endif
        {{ $attributes->class('h-4 w-4 rounded-[4px] accent-[var(--nx-accent)]') }} />
    @if ($label)<span>{{ $label }}</span>@endif
    {{ $slot }}
</label>
