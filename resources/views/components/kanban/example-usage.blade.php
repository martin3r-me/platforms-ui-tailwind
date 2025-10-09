{{-- Beispiel für die Verwendung des Toggle-Buttons --}}

{{-- Mit Toggle-Button --}}
<x-ui-kanban-board show-toggle="true" view="board">
    <x-ui-kanban-column title="To Do" sortable-id="todo">
        <x-ui-kanban-card title="Aufgabe 1" sortable-id="task-1">
            Beschreibung der Aufgabe
        </x-ui-kanban-card>
    </x-ui-kanban-column>
    
    <x-ui-kanban-column title="In Progress" sortable-id="progress">
        <x-ui-kanban-card title="Aufgabe 2" sortable-id="task-2">
            Arbeit in Bearbeitung
        </x-ui-kanban-card>
    </x-ui-kanban-column>
</x-ui-kanban-board>

{{-- Ohne Toggle-Button (nur Board-Ansicht) --}}
<x-ui-kanban-board view="board">
    <x-ui-kanban-column title="Done" sortable-id="done">
        <x-ui-kanban-card title="Aufgabe 3" sortable-id="task-3">
            Abgeschlossene Aufgabe
        </x-ui-kanban-card>
    </x-ui-kanban-column>
</x-ui-kanban-board>
