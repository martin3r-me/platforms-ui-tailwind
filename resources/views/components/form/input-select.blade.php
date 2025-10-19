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
    'displayMode'   => 'auto', // 'auto', 'dropdown', 'badges'
    'badgeSize'     => 'sm', // 'xs', 'sm', 'md', 'lg'
    'compactNull'   => true, // Im Badge-Modus "−" statt langem Text
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
            $normalized[$optValue] = $optLabel;
        }
    }
    elseif (is_array($options) && !empty($options) && is_object(reset($options))) {
        foreach ($options as $enumOption) {
            $optLabel = method_exists($enumOption, $optionLabel)
                ? $enumOption->{$optionLabel}()
                : data_get($enumOption, $optionLabel);
            $optValue = data_get($enumOption, $optionValue);
            $normalized[$optValue] = $optLabel;
        }
    } else {
        $normalized = $options;
    }

    $selected = old($name, $value ?? $attributes->get('value'));
    
    // Bestimme Anzeigemodus
    $optionCount = count($normalized) + ($nullable ? 1 : 0);
    $useBadges = $displayMode === 'badges' || ($displayMode === 'auto' && $optionCount < 10);

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
    $inactiveColorClasses = implode(' ', [
        "border-[rgb(var(--ui-{$allowed}-rgb))]",
        "text-[var(--ui-{$allowed})]",
        'bg-transparent',
        "hover:bg-[rgba(var(--ui-{$allowed}-rgb),0.08)]",
    ]);
    $activeColorClasses = implode(' ', [
        "bg-[rgb(var(--ui-{$allowed}-rgb))]",
        "text-[var(--ui-on-{$allowed})]",
        'border-transparent',
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
        <div class="flex flex-wrap gap-2" @if($hint) aria-describedby="{{ $name }}-hint" @endif>
            @if($nullable)
                <label class="inline-flex items-center rounded-lg cursor-pointer @if($disabled) opacity-50 cursor-not-allowed @endif">
                    <input 
                        type="radio" 
                        name="{{ $name }}" 
                        value="" 
                        @if($disabled) disabled @endif
                        @if($required) required @endif
                        class="sr-only peer"
                        {{ $attributes->whereStartsWith('wire:') }}
                        @checked($selected === '' || $selected === null)
                    />
                    <span class="{{ $nullBadgeSizeClass }} rounded-lg border transition-colors
                        border-[rgb(var(--ui-{$allowed}-rgb))] text-[var(--ui-{$allowed})] bg-transparent
                        hover:bg-[rgba(var(--ui-{$allowed}-rgb),0.08)]
                        peer-focus:outline-2 peer-focus:-outline-offset-2 peer-focus:outline-[rgb(var(--ui-{$allowed}-rgb))]
                        peer-checked:bg-[rgb(var(--ui-{$allowed}-rgb))] peer-checked:text-[var(--ui-on-{$allowed})] peer-checked:border-transparent
                        @if($selected === '' || $selected === null) bg-[rgb(var(--ui-{$allowed}-rgb))] text-[var(--ui-on-{$allowed})] border-transparent @endif
                    ">{{ $nullLabel }}</span>
                </label>
            @endif
            @foreach($normalized as $optionKey => $optionLabelNormalized)
                <label class="inline-flex items-center rounded-lg cursor-pointer @if($disabled) opacity-50 cursor-not-allowed @endif">
                    <input 
                        type="radio" 
                        name="{{ $name }}" 
                        value="{{ $optionKey }}" 
                        @if($disabled) disabled @endif
                        @if($required) required @endif
                        class="sr-only peer"
                        {{ $attributes->whereStartsWith('wire:') }}
                        @checked($selected == $optionKey)
                    />
                    <span class="{{ $badgeSizeClass }} rounded-lg border transition-colors
                        border-[rgb(var(--ui-{$allowed}-rgb))] text-[var(--ui-{$allowed})] bg-transparent
                        hover:bg-[rgba(var(--ui-{$allowed}-rgb),0.08)]
                        peer-focus:outline-2 peer-focus:-outline-offset-2 peer-focus:outline-[rgb(var(--ui-{$allowed}-rgb))]
                        peer-checked:bg-[rgb(var(--ui-{$allowed}-rgb))] peer-checked:text-[var(--ui-on-{$allowed})] peer-checked:border-transparent
                        @if($selected == $optionKey) bg-[rgb(var(--ui-{$allowed}-rgb))] text-[var(--ui-on-{$allowed})] border-transparent @endif
                    ">{{ $optionLabelNormalized }}</span>
                </label>
            @endforeach
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