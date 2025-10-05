{{-- resources/views/components/ui/confirm-button.blade.php --}}
@props([
    'action' => '', // Wire-Methode, z. B. deleteTask
    'value' => null, // NEU: Wert der an die Methode übergeben wird
    'text' => 'Löschen',
    'confirmText' => 'Wirklich löschen?',
    'class' => '',
    'variant' => 'muted',
    'icon' => null, // NEU: Icon für den Button
])

<x-ui-button
    :variant="$variant"
    size="md"
    :class="'hover:bg-danger-80 hover:text-on-danger w-full d-flex '.$class"
    x-data="{ confirm: false }"
    x-data="{ confirm: false }"
    x-on:click="
        if (!confirm) {
            confirm = true;
            $el.innerHTML = '{{ $confirmText }}';
            setTimeout(() => { confirm = false; $el.innerHTML = '{{ $text }}'; }, 3000);
        } else {
            $wire.call('{{ $action }}');
        }
    "
>
    <div class="d-flex gap-2">
        @if($icon)
            {!! $icon !!}
        @endif
        <span>{{ $text }}</span>
    </div>
</x-ui-button>