@props([
    // Container für eine Seite mit optionaler Navbar und Sidebar
])

<div class="h-full flex flex-col overflow-x-hidden" 
    x-data 
    x-init="
        if (!window.Alpine) return;
        if (!Alpine.store('page')) {
            Alpine.store('page', {
                sidebarOpen: JSON.parse(localStorage.getItem('page.sidebarOpen') ?? 'true'),
                activityOpen: JSON.parse(localStorage.getItem('page.activityOpen') ?? 'false'),
                terminalOpen: JSON.parse(localStorage.getItem('page.terminalOpen') ?? 'false'),
                timeEntryContext: null,
            });
        }
        $watch(() => Alpine.store('page').sidebarOpen, v => localStorage.setItem('page.sidebarOpen', JSON.stringify(v)))
        $watch(() => Alpine.store('page').activityOpen, v => localStorage.setItem('page.activityOpen', JSON.stringify(v)))
        $watch(() => Alpine.store('page').terminalOpen, v => localStorage.setItem('page.terminalOpen', JSON.stringify(v)))
    "
    @time-entry-context:set.window="Alpine.store('page').timeEntryContext = $event.detail"
>
    @isset($navbar)
        {{ $navbar }}
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


