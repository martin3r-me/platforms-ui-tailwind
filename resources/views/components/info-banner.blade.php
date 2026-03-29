@props([
  'icon' => null,
  'title' => null,
  'message' => null,
  'variant' => 'info', // info, success, warning, danger, neutral
])

@php
  $bg = [
    'info' => 'bg-[color:var(--ui-info-10)]',
    'success' => 'bg-[color:var(--ui-success-10)]',
    'warning' => 'bg-[color:var(--ui-warning-10)]',
    'danger' => 'bg-[color:var(--ui-danger-10)]',
    'neutral' => 'bg-[color:var(--ui-muted-10)]',
  ][$variant] ?? 'bg-[color:var(--ui-info-10)]';

  $text = [
    'info' => 'text-[color:var(--ui-info)]',
    'success' => 'text-[color:var(--ui-success)]',
    'warning' => 'text-[color:var(--ui-warning)]',
    'danger' => 'text-[color:var(--ui-danger)]',
    'neutral' => 'text-[color:var(--ui-muted)]',
  ][$variant] ?? 'text-[color:var(--ui-info)]';
@endphp

@php
  $borderColor = [
    'info' => 'border-[color:var(--ui-info-20)]',
    'success' => 'border-[color:var(--ui-success-20)]',
    'warning' => 'border-[color:var(--ui-warning-20)]',
    'danger' => 'border-[color:var(--ui-danger-20)]',
    'neutral' => 'border-[color:var(--ui-muted-20)]',
  ][$variant] ?? 'border-[color:var(--ui-info-20)]';
@endphp

<div class="rounded-lg border border-white/30 backdrop-blur-sm {{ $bg }} p-3">
  <div class="flex items-start gap-2">
    @if($icon)
      @svg($icon, 'w-5 h-5 '.$text)
    @endif
    <div class="flex-1">
      @if($title)
        <div class="font-semibold {{ $text }}">{{ $title }}</div>
      @endif
      @if($message)
        <div class="text-sm">{{ $message }}</div>
      @else
        <div class="text-sm">{{ $slot }}</div>
      @endif
    </div>
  </div>
  @isset($actions)
    <div class="mt-2">
      {{ $actions }}
    </div>
  @endisset
</div>


