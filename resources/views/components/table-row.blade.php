@props([
    'striped' => true,
    'hover' => true,
    'compact' => false,
    'clickable' => false,
    'href' => null,
])

@php
    $classes = ['border-bottom-1', 'border-bottom-muted', 'border-bottom-solid'];
    
    if ($hover) {
        $classes[] = 'hover:bg-primary-5 transition-colors';
    }
    
    if ($striped) {
        $classes[] = 'even:bg-muted-5';
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
