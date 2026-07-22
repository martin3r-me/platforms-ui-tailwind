{{--
    nx-badge — dezente Status-Pille (Notion-Stil: soft getönt).

    <x-nx-badge variant="success" dot>Veröffentlicht</x-nx-badge>
    <x-nx-badge>Entwurf</x-nx-badge>

      variant : neutral (default) | success | danger | warning | info | accent
      dot     : true -> führender Punkt in Textfarbe
--}}
@props([
    'variant' => 'neutral',
    'dot' => false,
])

@php
    $variantClass = match ($variant) {
        'success' => 'text-[color:var(--nx-success)] bg-[rgba(47,158,68,.12)]',
        'danger'  => 'text-[color:var(--nx-danger)] bg-[rgba(224,49,49,.12)]',
        'warning' => 'text-[color:var(--nx-warning)] bg-[rgba(232,89,12,.12)]',
        'info'    => 'text-[color:var(--nx-info)] bg-[rgba(25,113,194,.12)]',
        'accent'  => 'text-[color:var(--nx-on-accent)] bg-[color:var(--nx-accent)]',
        default   => 'text-[color:var(--nx-muted)] bg-[color:var(--nx-accent-soft)]',
    };
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-xs font-medium', $variantClass]) }}>
    @if ($dot)
        <span class="h-1.5 w-1.5 shrink-0 rounded-full" style="background:currentColor"></span>
    @endif
    {{ $slot }}
</span>
