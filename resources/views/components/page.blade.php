@props([
    // Container für eine Seite mit optionaler Navbar und Sidebar.
    // Fraktales Muster: innere Sidebar (Slot) läuft über die volle Höhe,
    // die Actionbar beginnt DANEBEN — analog zu Haupt-Sidebar/Navbar aussen.
])

<div class="h-full flex flex-col overflow-x-hidden">
    @isset($navbar)
        {{ $navbar }}
    @endisset

    <div class="flex-1 min-h-0 min-w-0 flex">
        @isset($sidebar)
            {{ $sidebar }}
        @endisset

        <div class="flex-1 min-h-0 min-w-0 flex flex-col">
            @isset($actionbar)
                {{ $actionbar }}
            @endisset

            <div class="flex-1 min-h-0 min-w-0 overflow-hidden flex">
                {{ $slot }}
            </div>
        </div>

        @isset($activity)
            {{ $activity }}
        @endisset
    </div>
</div>
