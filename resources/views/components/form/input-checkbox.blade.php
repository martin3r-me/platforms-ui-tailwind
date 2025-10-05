{{-- resources/views/components/ui/boolean-toggle.blade.php --}}
@props([
    'model',  // z.B. "task.is_done"
    'checkedLabel' => 'Erledigt',
    'uncheckedLabel' => 'Als erledigt markieren',
    'size' => 'md', // xs, sm, md, lg
    'disabled' => false,
    'block' => false, // NEU: volle Breite, wenn true
    'icon' => null, // NEU: Icon für den Button
    'variant' => 'success', // NEU: success, warning, etc.
])

@php
    $sizes = [
        'xs' => 'py-1 px-2 text-xs',
        'sm' => 'py-1 px-3 text-sm',
        'md' => 'py-2 px-4 text-md',
        'lg' => 'py-3 px-5 text-lg',
    ];
    $classes = $sizes[$size] ?? $sizes['md'];
    $blockClass = $block ? 'w-full d-block' : '';
@endphp

<button
    type="button"
    x-data="{ checked: @entangle($model) }"
    @click="if(!{{ $disabled ? 'true' : 'false' }}) checked = !checked"
    x-effect="$wire.set('{{ $model }}', checked)"
    :class="checked
        ? 'bg-{{ $variant }} text-on-{{ $variant }} hover:bg-{{ $variant }}-80'
        : 'bg-transparent border border-{{ $variant }} border-solid text-{{ $variant }} hover:bg-{{ $variant }} hover:text-on-{{ $variant }}'"
    class="rounded-md border-0 transition hover-scale-up shadow-sm font-medium d-inline-flex align-center justify-center gap-2 {{ $classes }} {{ $disabled ? 'opacity-60 pointer-events-none' : '' }} {{ $blockClass }}"
    :disabled="{{ $disabled ? 'true' : 'false' }}"
>
    @if($icon)
        <div class="flex items-center">
            {!! $icon !!}
        </div>
    @endif
    <span x-text="checked ? '{{ $checkedLabel }}' : '{{ $uncheckedLabel }}'"></span>
</button>