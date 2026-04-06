@props([
    'name',
    'label' => null,
    'variant' => 'primary',
    'size' => 'md',
    'errorKey' => null,
    'required' => false,
])

@php
    $errorKey = $errorKey ?: $name;
    $months = [
        1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April',
        5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Dezember',
    ];
    $currentYear = (int) date('Y');
    $yearStart = $currentYear + 1;
    $yearEnd = $currentYear - 5;

    $selectClasses = implode(' ', [
        'block w-full appearance-none rounded-md',
        'bg-[color:var(--ui-surface)] text-[color:var(--ui-secondary)]',
        'outline-1 -outline-offset-1 outline-[color:var(--ui-border)] border border-transparent',
        'transition-colors',
        "focus:outline-2 focus:-outline-offset-2 focus:outline-[color:rgb(var(--ui-{$variant}-rgb))]",
        'pl-3 pr-8 py-1.5 text-base sm:text-sm/6',
    ]);
@endphp

<div
    x-data="{
        day: '',
        month: '',
        year: '',
        init() {
            let val = $wire.get('{{ $name }}') || '';
            if (val && val.match(/^\d{4}-\d{2}-\d{2}$/)) {
                const parts = val.split('-');
                this.year = parseInt(parts[0]);
                this.month = parseInt(parts[1]);
                this.day = parseInt(parts[2]);
            } else {
                const now = new Date();
                this.day = now.getDate();
                this.month = now.getMonth() + 1;
                this.year = now.getFullYear();
                this.sync();
            }
        },
        sync() {
            if (this.day && this.month && this.year) {
                const d = String(this.day).padStart(2, '0');
                const m = String(this.month).padStart(2, '0');
                $wire.set('{{ $name }}', this.year + '-' + m + '-' + d);
            }
        }
    }"
    x-effect="sync()"
>
    @if($label)
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" size="sm" class="mb-1"/>
    @endif

    <div class="grid grid-cols-[5rem_1fr_6rem] gap-2">
        {{-- Tag --}}
        <div class="relative">
            <select x-model.number="day" class="{{ $selectClasses }}">
                @for($d = 1; $d <= 31; $d++)
                    <option value="{{ $d }}">{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}</option>
                @endfor
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="w-4 h-4 text-[color:var(--ui-muted)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>

        {{-- Monat --}}
        <div class="relative">
            <select x-model.number="month" class="{{ $selectClasses }}">
                @foreach($months as $num => $monthLabel)
                    <option value="{{ $num }}">{{ $monthLabel }}</option>
                @endforeach
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="w-4 h-4 text-[color:var(--ui-muted)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>

        {{-- Jahr --}}
        <div class="relative">
            <select x-model.number="year" class="{{ $selectClasses }}">
                @for($y = $yearStart; $y >= $yearEnd; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="w-4 h-4 text-[color:var(--ui-muted)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </div>
    </div>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>
