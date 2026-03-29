@props([
  'title' => null,
  'subtitle' => null,
  'class' => '',
])

<section {{ $attributes->merge(['class' => 'rounded-lg border border-[color:var(--ui-border)] bg-[color:var(--ui-surface)] shadow-sm '.$class]) }}>
  <header class="px-4 py-3 border-b border-[color:var(--ui-border)]">
    @if($title)
      <h3 class="text-base font-semibold text-[color:var(--ui-secondary)] m-0">{{ $title }}</h3>
    @endif
    @if($subtitle)
      <div class="text-xs text-[color:var(--ui-muted)]">{{ $subtitle }}</div>
    @endif
  </header>
  <div class="p-4">
    {{ $slot }}
  </div>
</section>


