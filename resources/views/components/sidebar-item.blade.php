@props([
    'href' => null,
    'active' => false,
    'type' => 'link', // 'link' oder 'button'
])

@if($type === 'button')
    <button type="button" {{ $attributes->merge(['class' => 'relative flex items-center p-2 rounded-md font-medium transition gap-3 text-[color:var(--nx-text)] w-full text-left']) }}
            :class="[ {{ $active ? 'true' : 'false' }} ? 'bg-[color:var(--nx-active)] text-[color:var(--nx-text)] font-semibold' : 'hover:bg-[color:var(--nx-hover)]' ]">
        {{ $slot }}
        @isset($trailing)
            <div class="ml-auto flex items-center gap-1">{{ $trailing }}</div>
        @endisset
    </button>
@else
    <a href="{{ $href ?? '#' }}" {{ $attributes->merge(['class' => 'relative flex items-center p-2 rounded-md font-medium transition gap-3 text-[color:var(--nx-text)]']) }}
       :class="[ {{ $active ? 'true' : 'false' }} ? 'bg-[color:var(--nx-active)] text-[color:var(--nx-text)] font-semibold' : 'hover:bg-[color:var(--nx-hover)]' ]"
       wire:navigate>
        {{ $slot }}
        @isset($trailing)
            <div class="ml-auto flex items-center gap-1">{{ $trailing }}</div>
        @endisset
    </a>
@endif


