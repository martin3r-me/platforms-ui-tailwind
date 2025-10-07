@props([
    // Container für eine Seite mit optionaler Navbar und Sidebar
])

<div class="h-full flex flex-col">
    @isset($navbar)
        {{ $navbar }}
    @endisset

    <div class="flex-1 min-h-0 flex">
        @isset($sidebar)
            {{ $sidebar }}
        @endisset

        <div class="flex-1 min-h-0 h-full overflow-hidden flex">
            {{ $slot }}
        </div>
    </div>
</div>


