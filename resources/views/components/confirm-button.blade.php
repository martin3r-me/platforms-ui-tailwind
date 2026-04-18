{{-- resources/views/components/ui/confirm-button.blade.php --}}
@props([
    'action' => '',
    'value' => null,
    'text' => 'Löschen',
    'confirmText' => 'Wirklich löschen?',
    'class' => '',
    'variant' => 'muted',
    'icon' => null,
    'size' => 'md',
])

@php
    $rawValue = false;

    // Support wire:click as fallback for action prop
    if (empty($action) && $attributes->has('wire:click')) {
        $wireClick = $attributes->get('wire:click');
        if (preg_match('/^(\w+)\((.+)\)$/', $wireClick, $m)) {
            $action = $m[1];
            $value = $value ?? $m[2];
            $rawValue = true; // already a JS-safe literal from the regex
        } else {
            $action = $wireClick;
        }
    }

    if (is_null($value)) {
        $wireCall = "\$wire.call('{$action}')";
    } elseif ($rawValue || is_numeric($value)) {
        $wireCall = "\$wire.call('{$action}', {$value})";
    } else {
        // Single quotes avoid conflict with double-quoted HTML attributes
        $escaped = str_replace(["\\", "'"], ["\\\\", "\\'"], $value);
        $wireCall = "\$wire.call('{$action}', '{$escaped}')";
    }
@endphp

<x-ui-button
    :variant="$variant"
    :size="$size"
    :class="'hover:bg-[color:var(--ui-danger-80)] hover:text-[color:var(--ui-on-danger)] w-full flex '.$class"
    x-data="{ confirming: false }"
    x-on:click="
        if (!confirming) {
            confirming = true;
            setTimeout(() => { confirming = false; }, 3000);
        } else {
            {{ $wireCall }}
        }
    "
>
    <span x-show="!confirming">
        <span class="flex gap-2 items-center">
            @if($icon)
                {!! $icon !!}
            @endif
            <span>{{ $text }}</span>
        </span>
    </span>
    <span x-show="confirming" x-cloak>{{ $confirmText }}</span>
</x-ui-button>
