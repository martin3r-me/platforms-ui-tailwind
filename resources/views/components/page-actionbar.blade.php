{{--
    nx Actionbar = Seitenkopf-NAVIGATION (ruhig, Hairline, übergleich). Drei Zonen:

      • Links (Nav):   Breadcrumb — die Navigation. Truncatet responsive.
      • left-Slot:     Inline-Controls neben der Nav (View-Umschalter, Filter, Nav-Dropdowns).
      • Rechts (Slot): SEITEN-Aktionen. Konvention:
                         – genau EINE klare Aktion  → sichtbarer <x-nx-button>
                         – ZWEI oder mehr Aktionen  → EIN <x-nx-dropdown label="Aktionen">
                       Keine Content-/Bulk-Aktionen hier (die gehören in eine Toolbar im Content).

    Beispiel:
      <x-ui-page-actionbar :breadcrumbs="[...]">
          <x-slot name="left"> … Filter/View-Switch … </x-slot>
          1 Aktion:   <x-nx-button variant="primary" wire:click="…">Anlegen</x-nx-button>
          >=2 Aktion: <x-nx-dropdown label="Aktionen"> … </x-nx-dropdown>
      </x-ui-page-actionbar>
--}}
@props([
    'breadcrumbs' => [],
])

<div class="relative shrink-0 z-30 px-4 h-11 bg-[color:var(--nx-surface)] border-b border-[color:var(--nx-line)]">
    <div class="h-full flex items-center gap-3">
        <!-- Links: Breadcrumbs + Actions (flexibel, schrumpft/kürzt) -->
        <div class="flex items-center gap-2 min-w-0 flex-1">
            <x-ui-breadcrumb :items="$breadcrumbs" />
            @isset($left)
                <div class="flex items-center gap-1 ml-2 pl-2 border-l border-[color:var(--nx-line)] shrink-0">
                    {{ $left }}
                </div>
            @endisset
        </div>
        <!-- Rechts: Action Buttons (fix, kein Schrumpfen) -->
        <div class="flex items-center gap-2 shrink-0">
            {{ $slot }}
        </div>
    </div>
</div>
