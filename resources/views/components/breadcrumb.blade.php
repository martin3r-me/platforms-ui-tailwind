@props([
    'items' => [], // Array von ['label' => '...', 'href' => '...', 'icon' => '...']
    'separator' => 'chevron-right',
    'size' => 'sm',
])

<nav class="flex items-center space-x-1 text-sm" aria-label="Breadcrumb">
    @foreach($items as $index => $item)
        @if($index > 0)
            <div class="flex items-center">
                @svg('heroicon-o-' . $separator, 'w-4 h-4 text-[var(--ui-muted)] mx-1')
            </div>
        @endif
        
        <div class="flex items-center">
            @if($item['icon'] ?? false)
                @svg('heroicon-o-' . $item['icon'], 'w-4 h-4 text-[var(--ui-muted)] mr-1')
            @endif
            
            @if($item['href'] ?? false)
                <a href="{{ $item['href'] }}" 
                   class="text-[var(--ui-secondary)] hover:text-[var(--ui-primary)] transition-colors font-medium"
                   @if($item['wire:navigate'] ?? false) wire:navigate @endif>
                    {{ $item['label'] }}
                </a>
            @else
                <span class="text-[var(--ui-muted)] font-medium">{{ $item['label'] }}</span>
            @endif
        </div>
    @endforeach
</nav>
