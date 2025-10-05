@props([
  'cols' => 2,
  'gap' => 6,
])

@php
  $colsClass = 'grid-cols-'.(int)$cols;
  $gapClass = 'gap-'.(int)$gap;
@endphp

<div class="grid {{ $colsClass }} {{ $gapClass }} items-start">
  <div>
    {{ $left ?? '' }}
  </div>
  <div>
    {{ $right ?? '' }}
  </div>
</div>


