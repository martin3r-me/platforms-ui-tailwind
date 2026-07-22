{{--
    nx-table — ruhige Tabelle (flush, ohne eigene Karte). In <x-nx-card flush> legen.
    Struktur wie gehabt: header / header-cell / body / row / cell.
    Wrappt in overflow-x-auto → scrollt auf schmalen Screens statt zu brechen.
--}}
@props(['compact' => false])

<div class="overflow-x-auto">
    <table class="w-full border-collapse text-sm">
        {{ $slot }}
    </table>
</div>
