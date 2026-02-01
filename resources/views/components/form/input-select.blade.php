@props([
    'name',
    'label'         => null,
    'hint'          => null,
    'options'       => [],
    'nullable'      => false,
    'nullLabel'     => '−',
    'variant'       => 'primary',
    'size'          => 'md',
    'errorKey'      => null,
    'required'      => false,
    'disabled'      => false,
    'autocomplete'  => null,
    'optionValue'   => 'value',
    'optionLabel'   => 'label',
    'value'         => null,
    'displayMode'   => 'auto', // 'auto', 'dropdown', 'badges', 'searchable'
    'badgeSize'     => 'sm', // 'xs', 'sm', 'md', 'lg'
    'compactNull'   => true, // Im Badge-Modus "−" statt langem Text
    'searchThreshold' => 20, // Ab dieser Anzahl wird automatisch Suche aktiviert
    'searchPlaceholder' => 'Suchen...', // Platzhalter für Suchfeld
])

@php
    $errorKey = $errorKey ?: $name;
    $sizeClass = match($size) {
        'xs' => 'pl-2 pr-8 py-1 text-xs',
        'sm' => 'pl-3 pr-8 py-1.5 text-sm',
        'lg' => 'pl-4 pr-8 py-2 text-lg',
        'xl' => 'pl-5 pr-8 py-2.5 text-xl',
        default => 'pl-4 pr-8 py-1.5 text-base sm:text-sm/6',
    };
    $normalized = [];

    if ($options instanceof \Illuminate\Support\Collection) {
        foreach ($options as $item) {
            $optValue = data_get($item, $optionValue);
            $optLabel = data_get($item, $optionLabel);
            if (is_object($item) && method_exists($item, $optionLabel)) {
                $optLabel = $item->{$optionLabel}();
            }
            // Sicherstellen, dass $optLabel ein String ist
            if (is_array($optLabel)) {
                $optLabel = json_encode($optLabel);
            }
            if ($optValue !== null && $optLabel !== null) {
                $normalized[$optValue] = (string) $optLabel;
            }
        }
    }
    elseif (is_array($options) && !empty($options) && is_object(reset($options))) {
        foreach ($options as $enumOption) {
            $optLabel = method_exists($enumOption, $optionLabel)
                ? $enumOption->{$optionLabel}()
                : data_get($enumOption, $optionLabel);
            $optValue = data_get($enumOption, $optionValue);
            // Sicherstellen, dass $optLabel ein String ist
            if (is_array($optLabel)) {
                $optLabel = json_encode($optLabel);
            }
            if ($optValue !== null && $optLabel !== null) {
                $normalized[$optValue] = (string) $optLabel;
            }
        }
    } elseif (is_array($options) && !empty($options) && is_array(reset($options))) {
        // Array von Arrays (z.B. [['id' => 1, 'name' => 'John'], ...])
        foreach ($options as $item) {
            $optValue = data_get($item, $optionValue);
            $optLabel = data_get($item, $optionLabel);
            // Sicherstellen, dass $optLabel ein String ist
            if (is_array($optLabel)) {
                $optLabel = json_encode($optLabel);
            }
            if ($optValue !== null && $optLabel !== null) {
                $normalized[$optValue] = (string) $optLabel;
            }
        }
    } else {
        // Fallback: Ursprüngliche Logik beibehalten für Abwärtskompatibilität
        // Einfaches assoziatives Array (z.B. ['key' => 'value']) wird direkt verwendet
        $normalized = $options;
        
        // Sicherheitsprüfung: Nur wenn Arrays als Werte enthalten sind, normalisieren wir
        if (is_array($normalized) && !empty($normalized)) {
            $hasNestedArrays = false;
            foreach ($normalized as $value) {
                if (is_array($value)) {
                    $hasNestedArrays = true;
                    break;
                }
            }
            
            // Nur wenn verschachtelte Arrays gefunden wurden, normalisieren wir
            if ($hasNestedArrays) {
                $tempNormalized = [];
                foreach ($normalized as $key => $value) {
                    if (is_array($value)) {
                        // Wenn der Wert ein Array ist, versuchen wir es zu normalisieren
                        $optValue = data_get($value, $optionValue, $key);
                        $optLabel = data_get($value, $optionLabel, is_array($value) ? json_encode($value) : $value);
                        if (is_array($optLabel)) {
                            $optLabel = json_encode($optLabel);
                        }
                        if ($optValue !== null && $optLabel !== null) {
                            $tempNormalized[$optValue] = (string) $optLabel;
                        }
                    } else {
                        // Einfache Werte beibehalten (abwärtskompatibel)
                        $tempNormalized[$key] = $value;
                    }
                }
                $normalized = $tempNormalized;
            }
        }
    }

    // Wert-Ermittlung für Badge-Hervorhebung
    // Bei Livewire: Der Wert wird über wire:model gesetzt, aber wir brauchen ihn für die Anzeige
    // Reihenfolge: 1. Expliziter value prop, 2. old() für Validierung, 3. wire:model Wert (wird von Livewire gesetzt)
    $selected = $value ?? old($name);
    
    // Bei Livewire wird der Wert direkt im Input gesetzt, nicht als PHP-Variable
    // Wir müssen daher auf den checked-Status im Input vertrauen
    // Für die initiale Anzeige verwenden wir den value prop oder old()
    
    // Bestimme Anzeigemodus
    $optionCount = count($normalized) + ($nullable ? 1 : 0);
    $useBadges = $displayMode === 'badges' || ($displayMode === 'auto' && $optionCount < 10);
    $useSearchable = $displayMode === 'searchable' || ($displayMode === 'auto' && $optionCount >= $searchThreshold);

    if ($useBadges && $compactNull) {
        $nullLabel = '−';
    }
    
    // Badge-Size Klassen
    $badgeSizeClass = match($badgeSize) {
        'xs' => 'px-3 py-1 text-xs',
        'sm' => 'px-4 py-1.5 text-sm',
        'md' => 'px-5 py-2 text-base',
        'lg' => 'px-6 py-2.5 text-lg',
        default => 'px-4 py-1.5 text-sm',
    };

    // Schmalere Variante speziell für die Null-Badge ("−")
    $nullBadgeSizeClass = match($badgeSize) {
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-3 py-2 text-base',
        'lg' => 'px-3.5 py-2.5 text-lg',
        default => 'px-2.5 py-1.5 text-sm',
    };

    // Farben wie in x-ui-button
    $allowed = in_array($variant, ['primary','success','secondary','info','warning','danger','muted']) ? $variant : 'primary';
    // Exakt wie x-ui-button: Outline vs. Filled
    $outlineClasses = implode(' ', [
        'bg-[var(--ui-surface)]',
        "text-[var(--ui-{$allowed})]",
        "border border-[var(--ui-border)]",
        "hover:bg-[rgba(var(--ui-{$allowed}-rgb),0.05)]",
        "hover:border-[rgb(var(--ui-{$allowed}-rgb))]",
        "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[rgb(var(--ui-{$allowed}-rgb))]",
    ]);
    $filledClasses = implode(' ', [
        "bg-[rgb(var(--ui-{$allowed}-rgb))]",
        "text-[var(--ui-on-{$allowed})]",
        "border-2 border-[rgb(var(--ui-{$allowed}-rgb))]",
        'shadow-lg',
        'font-bold',
        'ring-4 ring-[rgb(var(--ui-{$allowed}-rgb))] ring-opacity-30',
        'scale-105',
        'hover:opacity-90',
        "focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[rgb(var(--ui-{$allowed}-rgb))]",
    ]);
@endphp

<div>
    @if($label)
        <div class="flex items-center justify-between">
            <x-ui-label 
                :text="$label" 
                :for="$name" 
                :required="$required" 
                :variant="$variant" 
                size="sm" 
                class="mb-1"
            />
            @if($hint)
                <span id="{{ $name }}-hint" class="text-sm/6 text-[color:var(--ui-muted)]">{{ $hint }}</span>
            @endif
        </div>
    @endif

    @if($useBadges)
        {{-- Badge/Button Modus --}}
        <div 
            class="flex flex-wrap gap-2" 
            @if($hint) aria-describedby="{{ $name }}-hint" @endif
            x-data="{
                init() {
                    this.updateBadges();
                    // Bei Änderungen aktualisieren
                    this.$el.querySelectorAll('input[type=radio]').forEach(radio => {
                        radio.addEventListener('change', () => this.updateBadges());
                    });
                    // Bei Livewire-Updates aktualisieren (wenn wire:model vorhanden)
                    @if($attributes->whereStartsWith('wire:')->isNotEmpty())
                        Livewire.hook('morph.updated', () => {
                            setTimeout(() => this.updateBadges(), 10);
                        });
                    @endif
                },
                updateBadges() {
                    const checked = this.$el.querySelector('input[type=radio]:checked');
                    if (!checked) return;
                    
                    const selectedValue = checked.value;
                    this.$el.querySelectorAll('span[data-badge]').forEach(badge => {
                        const badgeValue = badge.getAttribute('data-badge');
                        if (badgeValue === selectedValue) {
                            badge.className = badge.getAttribute('data-filled-classes');
                        } else {
                            badge.className = badge.getAttribute('data-outline-classes');
                        }
                    });
                }
            }"
        >
            @if($nullable)
                @php
                    $isNullSelected = (string)($selected ?? '') === '';
                @endphp
                <label class="inline-flex items-center rounded-lg cursor-pointer @if($disabled) opacity-50 cursor-not-allowed @endif">
                    <input 
                        type="radio" 
                        name="{{ $name }}" 
                        value="" 
                        @if($disabled) disabled @endif
                        @if($required) required @endif
                        class="sr-only"
                        {{ $attributes->whereStartsWith('wire:') }}
                        @checked($isNullSelected)
                    />
                    <span 
                        data-badge=""
                        data-filled-classes="{{ $nullBadgeSizeClass }} rounded-lg transition-all duration-200 {{ $filledClasses }}"
                        data-outline-classes="{{ $nullBadgeSizeClass }} rounded-lg transition-all duration-200 {{ $outlineClasses }}"
                        class="{{ $nullBadgeSizeClass }} rounded-lg transition-all duration-200 {{ $isNullSelected ? $filledClasses : $outlineClasses }}"
                    >{{ $nullLabel }}</span>
                </label>
            @endif
            @foreach($normalized as $optionKey => $optionLabelNormalized)
                @php
                    $isOptionSelected = (string)$selected === (string)$optionKey;
                    // Sicherstellen, dass $optionLabelNormalized ein String ist
                    if (is_array($optionLabelNormalized)) {
                        $optionLabelNormalized = json_encode($optionLabelNormalized);
                    }
                    $optionLabelNormalized = (string) $optionLabelNormalized;
                @endphp
                <label class="inline-flex items-center rounded-lg cursor-pointer @if($disabled) opacity-50 cursor-not-allowed @endif">
                    <input 
                        type="radio" 
                        name="{{ $name }}" 
                        value="{{ $optionKey }}" 
                        @if($disabled) disabled @endif
                        @if($required) required @endif
                        class="sr-only"
                        {{ $attributes->whereStartsWith('wire:') }}
                        @checked($isOptionSelected)
                    />
                    <span 
                        data-badge="{{ $optionKey }}"
                        data-filled-classes="{{ $badgeSizeClass }} rounded-lg transition-all duration-200 {{ $filledClasses }}"
                        data-outline-classes="{{ $badgeSizeClass }} rounded-lg transition-all duration-200 {{ $outlineClasses }}"
                        class="{{ $badgeSizeClass }} rounded-lg transition-all duration-200 {{ $isOptionSelected ? $filledClasses : $outlineClasses }}"
                    >{{ $optionLabelNormalized }}</span>
                </label>
            @endforeach
        </div>
    @elseif($useSearchable)
        {{-- Searchable Dropdown Modus --}}
        @php
            // Label für den aktuell ausgewählten Wert ermitteln (mit String-Cast für robuste Vergleiche)
            $selectedLabelForSearchable = $nullLabel;
            if ($selected !== null && $selected !== '') {
                $selectedKey = (string) $selected;
                foreach ($normalized as $key => $label) {
                    if ((string) $key === $selectedKey) {
                        $selectedLabelForSearchable = $label;
                        break;
                    }
                }
            }
        @endphp
        <div
            class="relative"
            x-data="{
                open: false,
                search: '',
                selectedValue: '{{ $selected ?? '' }}',
                selectedLabel: '{{ addslashes($selectedLabelForSearchable) }}',
                options: {{ json_encode($normalized) }},
                nullable: {{ $nullable ? 'true' : 'false' }},
                nullLabel: '{{ $nullLabel }}',
                get filteredOptions() {
                    if (!this.search) return this.options;
                    const searchLower = this.search.toLowerCase();
                    const filtered = {};
                    for (const [key, label] of Object.entries(this.options)) {
                        if (label.toLowerCase().includes(searchLower)) {
                            filtered[key] = label;
                        }
                    }
                    return filtered;
                },
                selectOption(value, label) {
                    this.selectedValue = value;
                    this.selectedLabel = label;
                    this.open = false;
                    this.search = '';
                    this.$refs.hiddenInput.value = value;
                    this.$refs.hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }"
            @click.outside="open = false"
            @keydown.escape.window="open = false"
        >
            {{-- Hidden input for form submission --}}
            <input
                type="hidden"
                x-ref="hiddenInput"
                name="{{ $name }}"
                x-model="selectedValue"
                @if($required) required @endif
                {{ $attributes->whereStartsWith('wire:') }}
            />

            {{-- Display button --}}
            <button
                type="button"
                @click="open = !open"
                @if($disabled) disabled @endif
                class="{{ implode(' ', [
                    'block w-full text-left appearance-none rounded-md',
                    'bg-[var(--ui-surface)] text-[color:var(--ui-secondary)]',
                    'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-transparent',
                    'transition-colors',
                    "focus:outline-2 focus:-outline-offset-2 focus:outline-[color:rgb(var(--ui-{$variant}-rgb))]",
                    $sizeClass,
                    'pr-10',
                    $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
                ]) }}"
            >
                <span x-text="selectedLabel" class="block truncate"></span>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-4 h-4 text-[color:var(--ui-muted)]" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </button>

            {{-- Dropdown panel --}}
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute z-50 mt-1 w-full rounded-md bg-[var(--ui-surface)] shadow-lg ring-1 ring-[var(--ui-border)] max-h-60 overflow-hidden"
                style="display: none;"
            >
                {{-- Search input --}}
                <div class="p-2 border-b border-[var(--ui-border)]">
                    <input
                        type="text"
                        x-model="search"
                        x-ref="searchInput"
                        @click.stop
                        placeholder="{{ $searchPlaceholder }}"
                        class="{{ implode(' ', [
                            'block w-full rounded-md',
                            'bg-[var(--ui-surface)] text-[color:var(--ui-secondary)]',
                            'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-[var(--ui-border)]',
                            'transition-colors',
                            "focus:outline-2 focus:-outline-offset-2 focus:outline-[color:rgb(var(--ui-{$variant}-rgb))]",
                            'px-3 py-1.5 text-sm',
                        ]) }}"
                        x-init="$watch('open', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 50) })"
                    />
                </div>

                {{-- Options list --}}
                <ul class="overflow-auto max-h-48 py-1" role="listbox">
                    <template x-if="nullable">
                        <li
                            @click="selectOption('', nullLabel)"
                            :class="selectedValue === '' ? 'bg-[rgb(var(--ui-{{ $variant }}-rgb))] text-[var(--ui-on-{{ $variant }})]' : 'text-[color:var(--ui-secondary)] hover:bg-[rgba(var(--ui-{{ $variant }}-rgb),0.1)]'"
                            class="cursor-pointer select-none px-4 py-2 text-sm"
                            role="option"
                        >
                            <span x-text="nullLabel"></span>
                        </li>
                    </template>
                    <template x-for="(label, value) in filteredOptions" :key="value">
                        <li
                            @click="selectOption(value, label)"
                            :class="selectedValue === value ? 'bg-[rgb(var(--ui-{{ $variant }}-rgb))] text-[var(--ui-on-{{ $variant }})]' : 'text-[color:var(--ui-secondary)] hover:bg-[rgba(var(--ui-{{ $variant }}-rgb),0.1)]'"
                            class="cursor-pointer select-none px-4 py-2 text-sm"
                            role="option"
                        >
                            <span x-text="label"></span>
                        </li>
                    </template>
                    <template x-if="Object.keys(filteredOptions).length === 0">
                        <li class="px-4 py-2 text-sm text-[color:var(--ui-muted)] italic">
                            Keine Ergebnisse
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    @else
        {{-- Dropdown Modus (Original) --}}
        <div class="relative">
            <select
                id="{{ $name }}"
                name="{{ $name }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                @if($hint) aria-describedby="{{ $name }}-hint" @endif
                {{ $attributes->merge(['class' => implode(' ', [
                    'block w-full appearance-none rounded-md',
                    'bg-[var(--ui-surface)] text-[color:var(--ui-secondary)]',
                    'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-transparent',
                    'transition-colors',
                    "focus:outline-2 focus:-outline-offset-2 focus:outline-[color:rgb(var(--ui-{$variant}-rgb))]",
                    $sizeClass,
                    'pr-10',
                ])]) }}
            >
                @if($nullable)
                    <option value="">{{ $nullLabel }}</option>
                @endif
                @foreach($normalized as $optionKey => $optionLabelNormalized)
                    @php
                        // Sicherstellen, dass $optionLabelNormalized ein String ist
                        if (is_array($optionLabelNormalized)) {
                            $optionLabelNormalized = json_encode($optionLabelNormalized);
                        }
                        $optionLabelNormalized = (string) $optionLabelNormalized;
                    @endphp
                    <option value="{{ $optionKey }}" @selected($selected == $optionKey)>
                        {{ $optionLabelNormalized }}
                    </option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="w-4 h-4 text-[color:var(--ui-muted)]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
    @endif

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>