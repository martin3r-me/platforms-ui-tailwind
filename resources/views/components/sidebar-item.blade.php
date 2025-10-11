@props([
    'href' => null,
    'active' => false,
    'type' => 'link', // 'link' oder 'button'
])

@if($type === 'button')
    <button type="button" {{ $attributes->merge(['class' => 'relative flex items-center p-2 rounded-md font-medium transition gap-3 text-[var(--ui-secondary)] w-full text-left']) }}
            :class="[ {{ $active ? 'true' : 'false' }} ? 'bg-[rgb(var(--ui-primary-rgb))] text-[var(--ui-on-primary)] shadow-md' : 'hover:bg-[var(--ui-muted-5)] hover:shadow-sm' ]">
        {{ $slot }}
        @isset($trailing)
            <div class="ml-auto flex items-center gap-1">{{ $trailing }}</div>
        @endisset
    </button>
@else
    <a href="{{ $href ?? '#' }}" {{ $attributes->merge(['class' => 'relative flex items-center p-2 rounded-md font-medium transition gap-3 text-[var(--ui-secondary)]']) }}
       :class="[ {{ $active ? 'true' : 'false' }} ? 'bg-[rgb(var(--ui-primary-rgb))] text-[var(--ui-on-primary)] shadow-md' : 'hover:bg-[var(--ui-muted-5)] hover:shadow-sm' ]"
       wire:navigate>
        {{ $slot }}
        @isset($trailing)
            <div class="ml-auto flex items-center gap-1">{{ $trailing }}</div>
        @endisset
    </a>
@endif


