@props([
    'title' => '',
    'icon' => null,
    'team' => null,
])

<div class="sticky top-0 z-40">
    @auth
        @livewire('core.navbar')
    @endauth
</div>
