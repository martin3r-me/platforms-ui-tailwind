@props([
  'title' => null,
  'subtitle' => null,
  'class' => '',
])

<section {{ $attributes->merge(['class' => 'rounded-md border border-[var(--ui-border)] bg-white '.$class]) }}>
  <header class="p-3 border-b border-[var(--ui-border)]">
    @if($title)
      <h3 class="text-base font-semibold text-[var(--ui-secondary)] m-0">{{ $title }}</h3>
    @endif
    @if($subtitle)
      <div class="text-xs text-[var(--ui-muted)]">{{ $subtitle }}</div>
    @endif
  </header>
  <div class="p-3">
    {{ $slot }}
  </div>
</section>


