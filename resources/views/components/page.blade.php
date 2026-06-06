@props([
    // Container für eine Seite mit optionaler Navbar und Sidebar
])

<div class="h-full flex flex-col overflow-x-hidden">
    @isset($navbar)
        {{ $navbar }}
    @endisset

    @isset($actionbar)
        {{ $actionbar }}
    @endisset

    <div class="flex-1 min-h-0 min-w-0 flex">
        @isset($sidebar)
            {{ $sidebar }}
        @endisset

        <div class="flex-1 min-h-0 min-w-0 h-full overflow-hidden flex">
            {{ $slot }}
        </div>

        @isset($activity)
            {{ $activity }}
        @endisset
    </div>
</div>


