@props([
  'cols' => 4,
  'gap' => 4,
  'stats' => null, // optional: Array von [title, count, icon, variant]
])

@php
  $colsClass = match((int)$cols) {
      1 => 'grid-cols-1',
      2 => 'grid-cols-1 sm:grid-cols-2',
      3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
      4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
      5 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-5',
      6 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-6',
      default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
  };
  $gapClass = 'gap-'.(int)$gap;
@endphp

<div class="grid {{ $colsClass }} {{ $gapClass }}">
  @if(is_array($stats))
    @foreach($stats as $s)
      <x-ui-dashboard-tile
        :title="($s['title'] ?? '')"
        :count="($s['count'] ?? '')"
        :icon="($s['icon'] ?? null)"
        :variant="($s['variant'] ?? 'secondary')"
        size="sm"
      />
    @endforeach
  @else
    {{ $slot }}
  @endif
</div>
