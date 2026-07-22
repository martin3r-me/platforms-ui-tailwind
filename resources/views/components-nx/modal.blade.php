{{--
    nx-modal — ruhiger Dialog. API-kompatibel zu x-ui-modal.
    Wächst mit dem Inhalt (max-h 85vh + Scroll), nicht fixe 90vh.

    <x-nx-modal size="md" wire:model="showDetail">
        <x-slot name="header"> … </x-slot>
        … Body …
        <x-slot name="footer"> … </x-slot>
    </x-nx-modal>

      size     : sm | md (default) | lg | xl
      wire:model / :model  : Livewire-Boolean fürs Öffnen
      backdropClosable / escClosable / persistent / hideFooter
--}}
@props([
    'model' => null,
    'size' => 'md',
    'backdropClosable' => true,
    'escClosable' => true,
    'persistent' => false,
    'hideFooter' => false,
])

@php
    if ($model === null) {
        $wireModelAttr = $attributes->whereStartsWith('wire:model')->first();
        $model = $wireModelAttr
            ? trim(\Illuminate\Support\Str::after($wireModelAttr, 'wire:model='), '"\'')
            : 'modalShow';
    }

    $sizeClass = match ($size) {
        'sm' => 'max-w-md',
        'lg' => 'max-w-3xl',
        'xl' => 'max-w-5xl',
        default => 'max-w-xl',
    };

    $canBackdrop = ! $persistent && $backdropClosable;
    $canEsc = ! $persistent && $escClosable;
@endphp

<div x-data="{ open: $wire.entangle('{{ $model }}') }" x-show="open" x-cloak
    @keydown.window.escape="{{ $canEsc ? 'open = false' : '' }}"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-[rgba(15,15,15,.45)]" @click="{{ $canBackdrop ? 'open = false' : '' }}"
        x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- Panel --}}
    <div class="relative z-[101] flex w-full {{ $sizeClass }} max-h-[85vh] flex-col overflow-hidden rounded-[12px] border border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] text-[color:var(--nx-text)] shadow-[var(--nx-shadow-pop)]"
        x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

        @if (trim($header ?? ''))
            <div class="flex shrink-0 items-start justify-between gap-3 border-b border-[color:var(--nx-line)] px-5 py-4">
                <div class="min-w-0 flex-1">{{ $header }}</div>
                <button type="button" @click="open = false" aria-label="Schließen"
                    class="-mr-1.5 -mt-0.5 shrink-0 rounded-[6px] p-1.5 text-[color:var(--nx-muted)] transition-colors hover:bg-[color:var(--nx-hover)] hover:text-[color:var(--nx-text)]">
                    @svg('heroicon-o-x-mark', 'w-5 h-5')
                </button>
            </div>
        @endif

        <div class="min-h-0 flex-1 overflow-y-auto px-5 py-4">
            {{ $slot }}
        </div>

        @if (! $hideFooter && isset($footer))
            <div class="flex shrink-0 justify-end gap-2 border-t border-[color:var(--nx-line)] px-5 py-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
