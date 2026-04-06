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
        1 => 'Jan', 2 => 'Feb', 3 => 'Mär', 4 => 'Apr',
        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dez',
    ];
    $currentYear = (int) date('Y');
    $yearStart = $currentYear + 1;
    $yearEnd = $currentYear - 5;
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
        <x-ui-label :for="$name" :text="$label" :variant="$variant" :required="$required" :size="$size" class="mb-1"/>
    @endif

    <div class="flex gap-2">
        {{-- Tag --}}
        <select
            x-model.number="day"
            class="flex-1 rounded-lg border border-[var(--ui-border)]/60 bg-[var(--ui-surface)] px-3 py-2 text-sm text-[var(--ui-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
        >
            @for($d = 1; $d <= 31; $d++)
                <option value="{{ $d }}">{{ $d }}</option>
            @endfor
        </select>

        {{-- Monat --}}
        <select
            x-model.number="month"
            class="flex-[1.3] rounded-lg border border-[var(--ui-border)]/60 bg-[var(--ui-surface)] px-3 py-2 text-sm text-[var(--ui-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
        >
            @foreach($months as $num => $name_label)
                <option value="{{ $num }}">{{ $name_label }}</option>
            @endforeach
        </select>

        {{-- Jahr --}}
        <select
            x-model.number="year"
            class="flex-1 rounded-lg border border-[var(--ui-border)]/60 bg-[var(--ui-surface)] px-3 py-2 text-sm text-[var(--ui-secondary)] focus:outline-none focus:ring-2 focus:ring-[var(--ui-primary)]/20 focus:border-[var(--ui-primary)]"
        >
            @for($y = $yearStart; $y >= $yearEnd; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>
    </div>

    @error($errorKey)
        <span class="mt-1 text-[color:var(--ui-danger)] text-sm">{{ $message }}</span>
    @enderror
</div>
