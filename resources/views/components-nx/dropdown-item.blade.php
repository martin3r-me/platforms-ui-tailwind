{{--
    nx-dropdown-item — eine Zeile im nx-dropdown. Rendert <a> (href) oder <button>.
    wire:click / x-on etc. gehen via $attributes durch. Icon einfach in den Slot legen.

      href     : rendert <a>
      variant  : default | danger
      disabled : true -> ausgegraut, nicht klickbar
--}}
@props([
    'href' => null,
    'variant' => 'default',
    'disabled' => false,
])

@php
    $classes = [
        'flex w-full items-center gap-2.5 rounded-[6px] px-2.5 py-1.5 text-left text-sm transition-colors',
        'text-[color:var(--nx-danger)] hover:bg-[rgba(224,49,49,.08)]' => $variant === 'danger',
        'text-[color:var(--nx-text)] hover:bg-[color:var(--nx-hover)]' => $variant !== 'danger',
        'opacity-50 pointer-events-none' => $disabled,
    ];
@endphp

@if ($href && ! $disabled)
    <a href="{{ $href }}" @click="open = false" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button type="button" @click="open = false" {{ $attributes->class($classes) }} @if($disabled) disabled @endif>{{ $slot }}</button>
@endif
