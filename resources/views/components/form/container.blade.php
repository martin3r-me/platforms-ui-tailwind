@props([
  'title' => null,
  'description' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-lg border border-[color:var(--ui-border)]/60 bg-[var(--ui-surface)] shadow-sm']) }}>
  @if($title || $description)
    <div class="px-4 py-3 border-b border-[color:var(--ui-border)]/60">
      @if($title)
        <h3 class="text-sm font-semibold text-[color:var(--ui-secondary)] m-0">{{ $title }}</h3>
      @endif
      @if($description)
        <p class="text-xs text-[color:var(--ui-muted)] mt-1">{{ $description }}</p>
      @endif
    </div>
  @endif
  <div class="p-4">
    {{ $slot }}
  </div>
</section>


