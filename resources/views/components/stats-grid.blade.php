@props([
  'cols' => 4,
  'gap' => 4,
])

@php
  $colsClass = 'grid-cols-'.(int)$cols;
  $gapClass = 'gap-'.(int)$gap;
@endphp

<div class="grid {{ $colsClass }} {{ $gapClass }}">
  {{ $slot }}
  </div>


