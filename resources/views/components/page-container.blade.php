{{-- nx: weisser Content-Grund + warmer Text.
     Standard-Padding rundum, damit Inhalt nie an Sidebar/Actionbar klebt.
     width:
       full       -> volle Breite (Kanban, breite Tabellen, Canvas)
       contained  -> max-w 1200, linksbündig (Normalfall: Dashboards/Formulare/Listen) --}}
@props([
    'width' => 'full',                 // full | contained
    'padding' => 'px-6 py-6',
    'spacing' => 'space-y-8',
    'background' => 'bg-[color:var(--nx-surface)]',
])

{{-- data-nx-region: Breite = verfügbarer Platz (ändert sich bei Sidebar-Toggle) – Mess-Signal.
     data-nx-content: die tatsächliche Content-Kante – für die Ambient-Zone (rechter Rand). --}}
<div data-nx-region class="flex-1 overflow-y-auto overflow-x-hidden {{ $background }} text-[color:var(--nx-text)]">
    <div data-nx-content class="{{ $padding }} {{ $spacing }} {{ $width === 'contained' ? 'max-w-[1200px]' : 'w-full' }}">
        {{ $slot }}
    </div>
</div>
