@props([
    'items' => [], // Array von ['label' => '...', 'href' => '...', 'icon' => '...']
    'separator' => 'chevron-right',
    'size' => 'sm',
])

<nav class="flex items-center space-x-1 text-sm" aria-label="Breadcrumb">
    @foreach($items as $index => $item)
        @if($index > 0)
            <div class="flex items-center">
                @svg('heroicon-o-' . $separator, 'w-4 h-4 text-[color:var(--nx-faint)] mx-1')
            </div>
        @endif

        <div class="flex items-center">
            @if(($item['icon'] ?? false) && app('safe-svg')->resolve($item['icon'], 'heroicon-o-'))
                @svg('heroicon-o-' . $item['icon'], 'w-4 h-4 text-[color:var(--nx-faint)] mr-1')
            @endif

            @if($item['href'] ?? false)
                <a href="{{ $item['href'] }}"
                   class="text-[color:var(--nx-muted)] hover:text-[color:var(--nx-text)] transition-colors font-medium"
                   @if($item['wire:navigate'] ?? false) wire:navigate @endif>
                    {{ $item['label'] }}
                </a>
            @else
                <span class="text-[color:var(--nx-text)] font-medium">{{ $item['label'] }}</span>
            @endif
        </div>
    @endforeach
</nav>
