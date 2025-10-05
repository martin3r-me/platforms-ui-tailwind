@props([
    'striped' => true,
    'hover' => true,
    'compact' => false,
    'clickable' => false,
    'href' => null,
])

@php
    $classes = ['border-b', 'border-[color:var(--ui-border)]'];
    if ($hover) {
        $classes[] = 'hover:bg-[color:var(--ui-primary-5)] transition-colors';
    }
    if ($striped) {
        $classes[] = 'even:bg-[color:var(--ui-muted-5)]';
    }
    if ($clickable) {
        $classes[] = 'cursor-pointer';
    }
@endphp

<tr 
    class="{{ implode(' ', $classes) }}"
    @if($clickable && $href)
        onclick="window.location.href='{{ $href }}'"
        title="Klicken zum Bearbeiten"
    @endif
>
    {{ $slot }}
</tr>
