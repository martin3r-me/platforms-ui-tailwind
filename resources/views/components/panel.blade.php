@props([
  'title' => null,
  'subtitle' => null,
  'class' => '',
])

<section {{ $attributes->merge(['class' => 'rounded-xl bg-white/70 backdrop-blur-sm border border-white/40 shadow-[0_1px_3px_rgba(0,0,0,0.04),0_1px_2px_rgba(0,0,0,0.03)] '.$class]) }}>
  @if($title || $subtitle)
    <header class="px-4 py-3 border-b border-[color:var(--ui-border)]">
      @if($title)
        <h3 class="text-base font-semibold text-[color:var(--ui-secondary)] m-0">{{ $title }}</h3>
      @endif
      @if($subtitle)
        <div class="text-xs text-[color:var(--ui-muted)]">{{ $subtitle }}</div>
      @endif
    </header>
  @endif
  <div class="p-4">
    {{ $slot }}
  </div>
</section>


