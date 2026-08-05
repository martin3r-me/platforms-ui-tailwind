{{--
    x-ui-sticky-panel — Panel (nx-Card) mit klebendem Kopf.
    <x-ui-sticky-panel title="Dokumente" subtitle="…" flush>…</x-ui-sticky-panel>
--}}
@props([
    'title' => null,
    'subtitle' => null,
    'flush' => false,
])

<div {{ $attributes->class('rounded-[8px] bg-[color:var(--nx-surface)] border border-[color:var(--nx-line)] text-[color:var(--nx-text)]') }}>
    @if($title || $subtitle)
        <div class="sticky top-0 z-10 rounded-t-[8px] border-b border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] px-4 py-3">
            @if($title)
                <h3 class="m-0 text-sm font-semibold text-[color:var(--nx-text)]">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <div class="text-xs text-[color:var(--nx-muted)]">{{ $subtitle }}</div>
            @endif
        </div>
    @endif
    <div class="{{ $flush ? '' : 'p-4' }}">
        {{ $slot }}
    </div>
</div>
