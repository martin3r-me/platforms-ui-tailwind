@props([
  'title' => null,
  'subtitle' => null,
])

<div class="mb-4 flex items-center justify-between gap-3">
  <div>
    @if($title)
      <h1 class="text-2xl font-semibold text-[var(--ui-secondary)] m-0">{{ $title }}</h1>
    @endif
    @if($subtitle)
      <div class="text-sm text-[var(--ui-muted)]">{{ $subtitle }}</div>
    @endif
  </div>
  @isset($actions)
    <div class="flex items-center gap-2">
      {{ $actions }}
    </div>
  @endisset
</div>


