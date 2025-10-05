@props([
    'compact' => false,
])

<thead class="bg-[color:var(--ui-muted-5)]">
    <tr>
        {{ $slot }}
    </tr>
</thead>
