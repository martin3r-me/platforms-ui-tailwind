{{--
    nx-button — ruhiger Notion-Button. Schlanke API.

    <x-nx-button>Speichern</x-nx-button>
    <x-nx-button variant="primary" :href="route('...')">Öffnen</x-nx-button>
    <x-nx-button variant="ghost" icon wire:click="edit"><x-icon.pencil/></x-nx-button>

      variant : secondary (default) | primary | ghost | danger
      size    : sm (default) | md
      icon    : true  -> quadratischer Icon-Button
      href    : rendert <a> statt <button>
      disabled: true  -> ausgegraut, nicht klickbar
    Alles andere (wire:click, type, target, x-on:… ) geht via $attributes durch.
--}}
@props([
    'variant' => 'secondary',
    'size' => 'sm',
    'icon' => false,
    'href' => null,
    'disabled' => false,
])

@php
    $variantClass = match ($variant) {
        'primary' => 'bg-[color:var(--nx-accent)] text-[color:var(--nx-on-accent)] border border-transparent hover:bg-[color:var(--nx-accent-hover)]',
        'ghost'   => 'bg-transparent text-[color:var(--nx-text)] border border-transparent hover:bg-[color:var(--nx-hover)]',
        'danger'  => 'bg-[color:var(--nx-surface)] text-[color:var(--nx-danger)] border border-[color:var(--nx-line-strong)] hover:bg-[rgba(224,49,49,.08)]',
        default   => 'bg-[color:var(--nx-surface)] text-[color:var(--nx-text)] border border-[color:var(--nx-line-strong)] hover:bg-[color:var(--nx-hover)]',
    };

    $sizeClass = $icon
        ? ($size === 'md' ? 'h-9 w-9' : 'h-8 w-8')
        : ($size === 'md' ? 'h-9 px-3.5 gap-2' : 'h-8 px-3 gap-1.5');

    $classes = implode(' ', array_filter([
        'inline-flex items-center justify-center select-none whitespace-nowrap',
        'text-sm font-medium rounded-[6px] transition-colors',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--nx-line-strong)]',
        $variantClass,
        $sizeClass,
        $disabled ? 'opacity-50 pointer-events-none' : '',
    ]));
@endphp

@if ($href && ! $disabled)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }} @if($disabled) disabled @endif>{{ $slot }}</button>
@endif
