@props([
  'model' => null,           // wire:model Feldname
  'current' => null,         // aktueller Wert
  'options' => [],           // [['value' => 'x','label'=>'X','icon'=>'heroicon-o-user']]
  'size' => 'sm',            // xs, sm, md, lg
  'activeVariant' => 'primary',
])

@php
  $sizes = [
    'xs' => 'text-xs h-7 px-2',
    'sm' => 'text-sm h-8 px-3',
    'md' => 'text-base h-10 px-4',
    'lg' => 'text-lg h-12 px-5',
  ];
  $btn = $sizes[$size] ?? $sizes['sm'];
@endphp

<div class="inline-flex rounded-lg border border-[var(--ui-border)] bg-white overflow-hidden">
  @foreach($options as $idx => $opt)
    @php $isActive = ($current ?? '') === ($opt['value'] ?? null); @endphp
    <button type="button"
      @if($model) wire:click="$set('{{ $model }}','{{ $opt['value'] }}')" @endif
      class="inline-flex items-center gap-2 {{ $btn }} {{ $isActive ? 'bg-[rgb(var(--ui-'.$activeVariant.'-rgb))] text-[var(--ui-on-'.$activeVariant.')]' : 'bg-white text-[var(--ui-body-color)] hover:bg-[var(--ui-muted-5)]' }} {{ $idx>0 ? 'border-l border-[var(--ui-border)]' : '' }}">
      @if(isset($opt['icon']))
        @svg($opt['icon'], 'w-4 h-4')
      @endif
      <span>{{ $opt['label'] ?? $opt['value'] }}</span>
    </button>
  @endforeach
</div>


