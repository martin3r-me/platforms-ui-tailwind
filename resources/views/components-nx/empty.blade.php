{{--
    nx-empty — ruhiger Leerzustand (Icon + Text, optional Aktion).

    <x-nx-empty icon="heroicon-o-inbox">
        Keine Buchungen gefunden
        <x-slot name="action"><x-nx-button ...>Anlegen</x-nx-button></x-slot>
    </x-nx-empty>
--}}
@props(['icon' => 'heroicon-o-inbox'])

<div {{ $attributes->class('flex flex-col items-center justify-center gap-2 py-10 text-center text-[color:var(--nx-faint)]') }}>
    @svg($icon, 'w-8 h-8 opacity-40')
    <div class="text-xs">{{ $slot }}</div>
    @isset($action)
        <div class="mt-1">{{ $action }}</div>
    @endisset
</div>
