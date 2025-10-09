@props([
    // Container für eine Seite mit optionaler Navbar und Sidebar
])

<div class="h-full flex flex-col" x-data x-init="
    if (!window.Alpine) return;
    if (!Alpine.store('page')) {
        Alpine.store('page', {
            sidebarOpen: JSON.parse(localStorage.getItem('page.sidebarOpen') ?? 'true'),
            activityOpen: JSON.parse(localStorage.getItem('page.activityOpen') ?? 'false'),
        });
    }
    $watch(() => Alpine.store('page').sidebarOpen, v => localStorage.setItem('page.sidebarOpen', JSON.stringify(v)))
    $watch(() => Alpine.store('page').activityOpen, v => localStorage.setItem('page.activityOpen', JSON.stringify(v)))
">
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

        @isset($activity)
            {{ $activity }}
        @endisset
    </div>
</div>


