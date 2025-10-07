@props([
  'cols' => 4,
  'gap' => 4,
  'stats' => null, // optional: Array von [title, count, icon, variant]
])

@php
  $colsClass = 'grid-cols-'.(int)$cols;
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


