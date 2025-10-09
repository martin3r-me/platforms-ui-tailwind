{{--
  Component: Kanban Board (Organism)
  Zweck: Container für Kanban-Board mit Sortier-Funktionalität.
  Props:
    - wire:sortable: string - Wire-Methode für Spalten-Sortierung
    - wire:sortable-group: string - Wire-Methode für Karten-Sortierung
--}}

<div 
    {{ $attributes->only(['wire:sortable', 'wire:sortable-group'])->merge([
        'class' => 'h-full w-full flex gap-4 px-4 py-3 overflow-x-auto'
    ]) }}
>
    {{ $slot }}
</div>