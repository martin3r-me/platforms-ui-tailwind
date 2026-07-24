{{--
    nx-tab — einzelner Tab-Reiter innerhalb von <x-nx-tabs>.
    Aktiv = Text in Akzentfarbe + Unterstrich; inaktiv = gedämpft.

    <x-nx-tab :active="$tab === 'profile'" wire:click="setTab('profile')">Profil</x-nx-tab>

      active : bool — aktueller Reiter
--}}
@props([
    'active' => false,
])

<button type="button"
    {{ $attributes->class([
        'border-b-2 px-4 py-2 text-sm font-medium transition-colors',
        'border-[color:var(--nx-accent)] text-[color:var(--nx-text)]' => $active,
        'border-transparent text-[color:var(--nx-muted)] hover:text-[color:var(--nx-text)]' => ! $active,
    ]) }}>
    {{ $slot }}
</button>
