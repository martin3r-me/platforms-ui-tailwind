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
            @if(!is_null($value))
                $wire.call('{{ $action }}', {{ $value }});
            @else
                $wire.call('{{ $action }}');
            @endif
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