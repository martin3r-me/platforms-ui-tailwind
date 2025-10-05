<div class="d-flex h-full">
    <!-- Linke Spalte -->
    <div class="flex-grow-1 d-flex flex-col">
        <!-- Header oben (fix) -->
        <div class="border-top-1 border-bottom-1 border-muted border-top-solid border-bottom-solid p-2 flex-shrink-0">
            <div class="d-flex gap-1">
                <div class="d-flex">
                    @foreach($breadcrumbItems as $item)
                        @if($item)
                            @if(isset($item['current']) && $item['current'])
                                <span class="px-3 border-right-solid border-right-1 border-right-muted font-semibold">
                                    {{ $item['label'] }}
                                </span>
                            @else
                                <a href="{{ $item['href'] }}" class="px-3 border-right-solid border-right-1 border-right-muted underline" wire:navigate>
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        @endif
                    @endforeach
                </div>
                <div class="flex-grow-1 text-right d-flex items-center justify-end gap-2">
                    <span>{{ $task->title }}</span>
                    @if($canUpdate)
                        <x-ui-button 
                            variant="primary" 
                            size="sm"
                            wire:click="save"
                        >
                            <div class="d-flex items-center gap-2">
                                @svg('heroicon-o-check', 'w-4 h-4')
                                Speichern
                            </div>
                        </x-ui-button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Haupt-Content (nimmt Restplatz, scrollt) -->
        <div class="flex-grow-1 overflow-y-auto p-4">
            
            {{-- Aufgaben-Details --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-secondary">Aufgaben-Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui-input-text 
                        name="task.title"
                        label="Titel"
                        wire:model.live.debounce.500ms="task.title"
                        placeholder="Aufgabentitel eingeben..."
                        required
                        :errorKey="'task.title'"
                    />
                    <x-ui-input-select
                        name="task.priority"
                        label="Priorität"
                        :options="$priorityOptions"
                        optionValue="value"
                        optionLabel="label"
                        :nullable="false"
                        wire:model.live="task.priority"
                    />
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <x-ui-input-date
                        name="task.due_date"
                        label="Fälligkeitsdatum"
                        wire:model.live.debounce.500ms="task.due_date"
                        placeholder="Fälligkeitsdatum (optional)"
                        :nullable="true"
                        :errorKey="'task.due_date'"
                    />
                    <x-ui-input-select
                        name="task.story_points"
                        label="Story Points"
                        :options="$storyPointsOptions"
                        optionValue="value"
                        optionLabel="label"
                        :nullable="true"
                        nullLabel="– Story Points auswählen –"
                        wire:model.live="task.story_points"
                    />
                </div>
                <div class="mt-4">
                    <x-ui-input-textarea 
                        name="task.description"
                        label="Beschreibung"
                        wire:model.live.debounce.500ms="task.description"
                        placeholder="Aufgabenbeschreibung (optional)"
                        rows="4"
                        :errorKey="'task.description'"
                    />
                </div>
            </div>

            {{-- Status & Zuweisung --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-secondary">Status & Zuweisung</h3>
                <div class="grid grid-cols-2 gap-4">
                    <x-ui-input-checkbox
                        model="task.is_done"
                        checked-label="Erledigt"
                        unchecked-label="Als erledigt markieren"
                        size="md"
                        block="true"
                    />
                    <x-ui-input-checkbox
                        model="task.is_frog"
                        checked-label="Frosch (wichtig & unangenehm)"
                        unchecked-label="Als Frosch markieren"
                        size="md"
                        block="true"
                    />
                </div>
            </div>
        </div>

        <!-- Aktivitäten (immer unten) -->
        <div x-data="{ open: false }" class="flex-shrink-0 border-t border-muted">
            <div 
                @click="open = !open" 
                class="cursor-pointer border-top-1 border-top-solid border-top-muted border-bottom-1 border-bottom-solid border-bottom-muted p-2 text-center d-flex items-center justify-center gap-1 mx-2 shadow-lg"
            >
                AKTIVITÄTEN 
                <span class="text-xs">
                    {{$task->activities->count()}}
                </span>
                <x-heroicon-o-chevron-double-down 
                    class="w-3 h-3" 
                    x-show="!open"
                />
                <x-heroicon-o-chevron-double-up 
                    class="w-3 h-3" 
                    x-show="open"
                />
            </div>
            <div x-show="open" class="p-2 max-h-xs overflow-y-auto">
                <livewire:activity-log.index
                    :model="$task"
                    :key="get_class($task) . '_' . $task->id"
                />
            </div>
        </div>
    </div>

    <!-- Rechte Spalte -->
    <div class="min-w-80 w-80 d-flex flex-col border-left-1 border-left-solid border-left-muted">

        <div class="d-flex gap-2 border-top-1 border-bottom-1 border-muted border-top-solid border-bottom-solid p-2 flex-shrink-0">
            <x-heroicon-o-cog-6-tooth class="w-6 h-6"/>
            Einstellungen
        </div>
        <div class="flex-grow-1 overflow-y-auto p-4">

            {{-- Navigation Buttons --}}
            <div class="d-flex flex-col gap-2 mb-4">
                @if($task->project)
                    <x-ui-button 
                        variant="secondary-outline" 
                        size="md" 
                        :href="route($projectRoute, ['plannerProject' => $task->project->id])" 
                        wire:navigate
                        class="w-full"
                    >
                        <div class="d-flex items-center gap-2">
                            @svg('heroicon-o-arrow-left', 'w-4 h-4')
                            Zum Projekt
                        </div>
                    </x-ui-button>
                @endif
                <x-ui-button 
                    variant="secondary-outline" 
                    size="md" 
                    :href="route($myTasksRoute)" 
                    wire:navigate
                    class="w-full"
                >
                    <div class="d-flex items-center gap-2">
                        @svg('heroicon-o-arrow-left', 'w-4 h-4')
                        Zu meinen Aufgaben
                    </div>
                </x-ui-button>
            </div>

            {{-- Kurze Übersicht --}}
            <div class="mb-4 p-3 bg-muted-5 rounded-lg">
                <h4 class="font-semibold mb-2 text-secondary">Aufgaben-Übersicht</h4>
                <div class="space-y-1 text-sm">
                    <div><strong>Titel:</strong> {{ $task->title }}</div>
                    @if($task->project)
                        <div><strong>Projekt:</strong> {{ $task->project->name }}</div>
                    @endif
                    @if($task->due_date)
                        <div><strong>Fällig:</strong> {{ $task->due_date->format('d.m.Y') }}</div>
                    @endif
                    @if($task->story_points)
                        <div><strong>Story Points:</strong> {{ $task->story_points }}</div>
                    @endif
                </div>
            </div>

            {{-- Status --}}
            <x-ui-input-checkbox
                model="task.is_done"
                checked-label="Aufgabe erledigt"
                unchecked-label="Als erledigt markieren"
                size="md"
                block="true"
            />

            <hr>

            {{-- Aktionen --}}
            <div class="mb-4">
                <h4 class="font-semibold mb-2">Aktionen</h4>
                <div class="space-y-2">
                    @if($canDelete)
                        <x-ui-confirm-button 
                            action="delete" 
                            text="Aufgabe löschen" 
                            confirmText="Wirklich löschen?" 
                            variant="danger-outline"
                            :icon="@svg('heroicon-o-trash', 'w-4 h-4')->toHtml()"
                            class="w-full"
                        />
                    @endif
                </div>
            </div>

            <hr>

        </div>
    </div>
</div>
