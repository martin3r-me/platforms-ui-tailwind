{{--
    nx-dropdown — kompaktes Aktions-/Navigationsmenü (Trigger + Panel).
    Standard-Trigger = Kebab (⋯); mit :label wird's ein "Label ▾"-Button.
    Dient in der Actionbar rechts als EINZIGES Control (Aktionen gebündelt) und ist
    zugleich die responsive Lösung (gleiches Menü auf Desktop + Mobil).

    <x-nx-dropdown label="Aktionen">
        <x-nx-dropdown-item :href="route(...)">@svg('heroicon-o-eye','w-4 h-4') Öffnen</x-nx-dropdown-item>
        <x-nx-dropdown-item wire:click="publish">Veröffentlichen</x-nx-dropdown-item>
        <x-nx-dropdown-divider />
        <x-nx-dropdown-item variant="danger" wire:click="delete">Löschen</x-nx-dropdown-item>
    </x-nx-dropdown>

      align : end (default, rechtsbündig) | start
      label : optional; ohne label = Kebab-Icon-Trigger
      width : Panel-Breite (Default w-56)
--}}
@props([
    'align' => 'end',
    'label' => null,
    'width' => 'w-56',
])

<div x-data="{ open: false }" @keydown.escape.window="open = false" class="relative inline-block text-left">
    <button type="button" @click="open = ! open" :aria-expanded="open" aria-haspopup="true"
        {{ $attributes->class([
            'inline-flex items-center justify-center gap-1.5 select-none rounded-[6px] text-sm font-medium transition-colors',
            'text-[color:var(--nx-text)] hover:bg-[color:var(--nx-hover)]',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--nx-line-strong)]',
            'h-8 w-8' => ! $label,
            'h-8 px-3' => (bool) $label,
        ]) }}>
        @if ($label)
            <span>{{ $label }}</span>
            <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        @else
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <circle cx="10" cy="4" r="1.4"/><circle cx="10" cy="10" r="1.4"/><circle cx="10" cy="16" r="1.4"/>
            </svg>
        @endif
    </button>

    <div x-show="open" style="display:none" @click.outside="open = false" x-transition
        class="absolute z-50 mt-1.5 {{ $align === 'end' ? 'right-0' : 'left-0' }} {{ $width }} rounded-[8px] border border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] p-1 shadow-[var(--nx-shadow-pop)]">
        {{ $slot }}
    </div>
</div>
