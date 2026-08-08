@props([
    'items' => [], // Array von ['label' => '...', 'href'|'route' => '...', 'params' => [...], 'icon' => '...']
    'separator' => 'chevron-right',
    'size' => 'sm',
])

@php $lastIndex = count($items) - 1; @endphp
<nav class="flex items-center space-x-1 text-sm min-w-0" aria-label="Breadcrumb">
    @foreach($items as $index => $item)
        @php
            $isLast = $index === $lastIndex;
            // Vertrag: Views geben meist 'route' (+ optional 'params'); wir lösen es hier zu href auf.
            // Der letzte Eintrag = aktuelle Seite → nie ein Link.
            $href = $item['href'] ?? null;
            if (!$href && !$isLast && !empty($item['route']) && \Illuminate\Support\Facades\Route::has($item['route'])) {
                $href = route($item['route'], $item['params'] ?? []);
            }
            if ($isLast) { $href = null; }
            $nav = $item['wire:navigate'] ?? (bool) $href;
        @endphp
        {{-- Separator + Vorfahren mobil ausblenden, ab sm sichtbar --}}
        @if($index > 0)
            <div class="items-center shrink-0 hidden sm:flex">
                @svg('heroicon-o-' . $separator, 'w-4 h-4 text-[color:var(--nx-faint)] mx-1')
            </div>
        @endif

        <div class="items-center min-w-0 {{ $isLast ? 'flex' : 'hidden sm:flex shrink-0' }}">
            @if(($item['icon'] ?? false) && app('safe-svg')->resolve($item['icon'], 'heroicon-o-'))
                @svg('heroicon-o-' . $item['icon'], 'w-4 h-4 shrink-0 text-[color:var(--nx-faint)] mr-1')
            @endif

            @if($href)
                <a href="{{ $href }}"
                   class="text-[color:var(--nx-muted)] hover:text-[color:var(--nx-text)] transition-colors font-medium {{ $isLast ? 'truncate' : 'whitespace-nowrap' }}"
                   @if($nav) wire:navigate @endif>
                    {{ $item['label'] }}
                </a>
            @else
                <span class="text-[color:var(--nx-text)] font-medium {{ $isLast ? 'truncate' : 'whitespace-nowrap' }}">{{ $item['label'] }}</span>
            @endif
        </div>
    @endforeach
</nav>
