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
    $wireCall = is_null($value)
        ? "\$wire.call('{$action}')"
        : "\$wire.call('{$action}', " . json_encode($value) . ")";
@endphp

<x-ui-button
    :variant="$variant"
    :size="$size"
    :class="'hover:bg-[color:var(--ui-danger-80)] hover:text-[color:var(--ui-on-danger)] w-full flex '.$class"
    x-data="{ confirm: false }"
    x-on:click="
        if (!confirm) {
            confirm = true;
            $el.innerHTML = '{{ $confirmText }}';
            setTimeout(() => { confirm = false; $el.innerHTML = '{{ $text }}'; }, 3000);
        } else {
            {!! $wireCall !!}
        }
    "
>
    <div class="flex gap-2 items-center">
        @if($icon)
            {!! $icon !!}
        @endif
        <span>{{ $text }}</span>
    </div>
</x-ui-button>