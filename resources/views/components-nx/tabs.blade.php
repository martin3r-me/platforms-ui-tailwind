{{--
    nx-tabs — Tab-Leiste (Notion-Stil: ruhige Unterstrich-Navigation).
    Container für <x-nx-tab>-Items; zeichnet die Hairline-Grundlinie.

    <x-nx-tabs>
        <x-nx-tab :active="$tab === 'a'" wire:click="setTab('a')">Erste</x-nx-tab>
        <x-nx-tab :active="$tab === 'b'" wire:click="setTab('b')">Zweite</x-nx-tab>
    </x-nx-tabs>
--}}
<div {{ $attributes->class(['mb-6 border-b border-[color:var(--nx-line)]']) }}>
    <nav class="-mb-px flex gap-1">
        {{ $slot }}
    </nav>
</div>
