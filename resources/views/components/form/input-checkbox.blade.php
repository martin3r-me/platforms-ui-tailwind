{{-- resources/views/components/ui/boolean-toggle.blade.php --}}
@props([
    'model',
    'checkedLabel' => 'Erledigt',
    'uncheckedLabel' => 'Als erledigt markieren',
    'size' => 'md',
    'disabled' => false,
    'block' => false,
    'icon' => null,
    'variant' => 'success',
])

@php
    $sizes = [
        'xs' => 'py-1 px-2 text-xs',
        'sm' => 'py-1 px-3 text-sm',
        'md' => 'py-2 px-4 text-base',
        'lg' => 'py-3 px-5 text-lg',
    ];
    $classes = $sizes[$size] ?? $sizes['md'];
    $blockClass = $block ? 'w-full block' : '';
@endphp

<button
    type="button"
    x-data="{ checked: @entangle($model) }"
    @click="if(!{{ $disabled ? 'true' : 'false' }}) checked = !checked"
    x-effect="$wire.set('{{ $model }}', checked)"
    :class="checked
        ? 'bg-[rgb(var(--ui-{{ $variant }}-rgb))] text-[color:var(--ui-on-{{ $variant }})] hover:opacity-90'
        : 'bg-transparent border border-[color:rgb(var(--ui-{{ $variant }}-rgb))] text-[color:var(--ui-{{ $variant }})] hover:bg-[rgb(var(--ui-{{ $variant }}-rgb))] hover:text-[color:var(--ui-on-{{ $variant }})]'"
    class="rounded-md border-0 transition shadow-sm font-medium inline-flex items-center justify-center gap-2 {{ $classes }} {{ $disabled ? 'opacity-60 pointer-events-none' : '' }} {{ $blockClass }}"
    :disabled="{{ $disabled ? 'true' : 'false' }}"
>
    @if($icon)
        <div class="flex items-center">
            {!! $icon !!}
        </div>
    @endif
    <span x-text="checked ? '{{ $checkedLabel }}' : '{{ $uncheckedLabel }}'"></span>
</button>