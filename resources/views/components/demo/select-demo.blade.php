{{--
Demo für erweiterte Select-Komponente mit Badge/Button-Modus
--}}

<div class="space-y-8 p-6">
    <h2 class="text-2xl font-bold text-[color:var(--ui-secondary)]">Select-Komponente Demo</h2>
    
    {{-- Story Points (6 Optionen - sollte als Badges angezeigt werden) --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-[color:var(--ui-secondary)]">Story Points (Auto-Modus - Badges)</h3>
        <x-ui-input-select
            name="story_points_auto"
            label="Story Points (Auto)"
            :options="[
                'xs' => 'XS',
                's' => 'S', 
                'm' => 'M',
                'l' => 'L',
                'xl' => 'XL',
                'xxl' => 'XXL'
            ]"
            :nullable="true"
            nullLabel="– Kein Wert –"
            wire:model.live="storyPointsAuto"
        />
    </div>

    {{-- Story Points (Explizit Badges) --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-[color:var(--ui-secondary)]">Story Points (Explizit Badges)</h3>
        <x-ui-input-select
            name="story_points_badges"
            label="Story Points (Badges)"
            :options="[
                'xs' => 'XS',
                's' => 'S', 
                'm' => 'M',
                'l' => 'L',
                'xl' => 'XL',
                'xxl' => 'XXL'
            ]"
            :nullable="true"
            nullLabel="– Kein Wert –"
            displayMode="badges"
            badgeSize="md"
            wire:model.live="storyPointsBadges"
        />
    </div>

    {{-- Viele Optionen (sollte als Dropdown angezeigt werden) --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-[color:var(--ui-secondary)]">Viele Optionen (Auto-Modus - Dropdown)</h3>
        <x-ui-input-select
            name="many_options"
            label="Viele Optionen (Auto)"
            :options="[
                '1' => 'Option 1',
                '2' => 'Option 2',
                '3' => 'Option 3',
                '4' => 'Option 4',
                '5' => 'Option 5',
                '6' => 'Option 6',
                '7' => 'Option 7',
                '8' => 'Option 8',
                '9' => 'Option 9',
                '10' => 'Option 10',
                '11' => 'Option 11',
                '12' => 'Option 12'
            ]"
            :nullable="true"
            nullLabel="– Kein Wert –"
            wire:model.live="manyOptions"
        />
    </div>

    {{-- Explizit Dropdown --}}
    <div class="space-y-4">
        <h3 class="text-lg font-semibold text-[color:var(--ui-secondary)]">Explizit Dropdown</h3>
        <x-ui-input-select
            name="explicit_dropdown"
            label="Explizit Dropdown"
            :options="[
                'xs' => 'XS',
                's' => 'S', 
                'm' => 'M',
                'l' => 'L',
                'xl' => 'XL',
                'xxl' => 'XXL'
            ]"
            :nullable="true"
            nullLabel="– Kein Wert –"
            displayMode="dropdown"
            wire:model.live="explicitDropdown"
        />
    </div>

    {{-- Aktuelle Werte anzeigen --}}
    <div class="mt-8 p-4 bg-[var(--ui-muted-5)] rounded-lg">
        <h3 class="text-lg font-semibold text-[color:var(--ui-secondary)] mb-2">Aktuelle Werte:</h3>
        <ul class="space-y-1 text-sm">
            <li><strong>Story Points (Auto):</strong> {{ $storyPointsAuto ?? 'Nicht ausgewählt' }}</li>
            <li><strong>Story Points (Badges):</strong> {{ $storyPointsBadges ?? 'Nicht ausgewählt' }}</li>
            <li><strong>Viele Optionen:</strong> {{ $manyOptions ?? 'Nicht ausgewählt' }}</li>
            <li><strong>Explizit Dropdown:</strong> {{ $explicitDropdown ?? 'Nicht ausgewählt' }}</li>
        </ul>
    </div>
</div>
