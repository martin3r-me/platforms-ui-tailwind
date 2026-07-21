@props([
    'title' => '',
    'width' => 'w-80',         // expanded width (Tailwind class — wird zu Default-px geparst)
    'defaultOpen' => true,
    'storeKey' => 'sidebarOpen', // 'sidebarOpen' (links) | 'activityOpen' (rechts)
    'side' => 'left',            // 'left' | 'right'
    'icon' => null,              // optionaler Heroicon-Name fürs Rail
    'railWidth' => 'w-11',       // collapsed rail width (~44px)
    'minWidth' => 200,           // resize min in px
    'maxWidth' => 640,           // resize max in px
])

@php
    // storeKey → Scope-Name im UI-Store
    $scope = $storeKey === 'activityOpen' ? 'activity' : 'page_sidebar';
    $borderClass = $side === 'right' ? 'border-l border-[color:var(--nx-line)]' : 'border-r border-[color:var(--nx-line)]';
    $expandIcon = $side === 'right' ? 'heroicon-o-chevron-double-left' : 'heroicon-o-chevron-double-right';

    // Default-Breite aus Tailwind-Klasse in Pixel ableiten
    $widthMap = [
        'w-56' => 224, 'w-60' => 240, 'w-64' => 256, 'w-72' => 288,
        'w-80' => 320, 'w-96' => 384,
    ];
    $defaultWidthPx = $widthMap[$width] ?? 320;
@endphp

<div
    x-data="{
        scope: @js($scope),
        defaultOpen: @js((bool) $defaultOpen),
        defaultWidth: {{ $defaultWidthPx }},
        resizing: false,
        get open() {
            const v = this.$store.ui?.m(this.scope, 'open');
            return v === undefined ? this.defaultOpen : v;
        },
        get width() {
            const v = this.$store.ui?.m(this.scope, 'width');
            const w = v === undefined ? this.defaultWidth : v;
            return Math.max({{ $minWidth }}, Math.min({{ $maxWidth }}, w));
        },
        setOpen(v) { this.$store.ui?.mSet(this.scope, 'open', v); },
        startResize(e) {
            this.resizing = true;
            const startX = e.clientX;
            const startWidth = this.width;
            const side = '{{ $side }}';
            const MIN = {{ $minWidth }};
            const MAX = {{ $maxWidth }};
            const onMouseMove = (ev) => {
                const delta = ev.clientX - startX;
                const adjusted = side === 'left' ? startWidth + delta : startWidth - delta;
                const next = Math.max(MIN, Math.min(MAX, adjusted));
                this.$store.ui?.mSet(this.scope, 'width', next);
            };
            const onMouseUp = () => {
                this.resizing = false;
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            };
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }
    }"
    :style="open ? ('width: ' + width + 'px') : 'width: 44px'"
    :class="resizing ? '' : 'transition-all duration-200'"
    class="relative flex-shrink-0 h-full bg-[color:var(--nx-surface)] overflow-x-hidden {{ $borderClass }}"
    {{ $attributes }}
>
    {{-- Collapsed Rail --}}
    <button
        type="button"
        x-show="!open"
        x-cloak
        @click="setOpen(true)"
        class="group/rail h-full w-full flex flex-col items-center justify-between py-3 px-2 hover:bg-[color:var(--nx-hover)] transition-colors cursor-pointer"
        title="@if($title){{ $title }} öffnen @else Öffnen @endif"
    >
        @if($icon)
            <span class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-[color:var(--nx-surface)] border border-[color:var(--nx-line)] flex-shrink-0">
                @svg($icon, 'w-3.5 h-3.5 text-[color:var(--nx-text)]')
            </span>
        @else
            @svg($expandIcon, 'w-4 h-4 text-[color:var(--nx-text)] group-hover/rail:text-[color:var(--nx-text)] transition-colors flex-shrink-0')
        @endif

        @if($title)
            <span
                class="text-[10px] font-semibold uppercase tracking-wider text-[color:var(--nx-muted)] group-hover/rail:text-[color:var(--nx-text)] transition-colors my-2 truncate"
                style="writing-mode: vertical-rl; transform: rotate(180deg); max-height: 100%;"
            >
                {{ $title }}
            </span>
        @else
            <span class="flex-1"></span>
        @endif

        @if($icon)
            @svg($expandIcon, 'w-4 h-4 text-[color:var(--nx-text)] group-hover/rail:text-[color:var(--nx-text)] transition-colors flex-shrink-0')
        @else
            <span class="block w-1.5 h-1.5"></span>
        @endif
    </button>

    {{-- Expanded Content --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="h-full overflow-hidden overflow-x-hidden flex flex-col"
    >
        @if($title)
            <div class="px-6 h-14 flex-shrink-0 flex items-center border-b border-[color:var(--nx-line)] bg-[color:var(--nx-surface)] backdrop-blur">
                @if($icon)
                    <span class="inline-flex items-center justify-center w-5 h-5 mr-2 text-[color:var(--nx-text)]">
                        @svg($icon, 'w-4 h-4')
                    </span>
                @endif
                <h2 class="text-sm font-semibold text-[color:var(--nx-text)] m-0 tracking-wide uppercase truncate">{{ $title }}</h2>
                <button
                    type="button"
                    @click="setOpen(false)"
                    class="ml-auto inline-flex items-center justify-center w-7 h-7 rounded-md text-[color:var(--nx-text)] hover:text-[color:var(--nx-text)] hover:bg-[color:var(--nx-hover)] transition-colors flex-shrink-0"
                    title="Einklappen"
                >
                    @if($side === 'right')
                        @svg('heroicon-o-chevron-double-right', 'w-4 h-4')
                    @else
                        @svg('heroicon-o-chevron-double-left', 'w-4 h-4')
                    @endif
                </button>
            </div>
        @endif

        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            {{ $slot }}
        </div>
    </div>

    {{-- Resize-Handle (nur im expanded state, klebt an der nach außen zeigenden Kante) --}}
    <div
        x-show="open"
        @mousedown.prevent="startResize($event)"
        class="absolute top-0 {{ $side === 'right' ? 'left-0' : 'right-0' }} w-1 h-full cursor-ew-resize group/resize z-20"
    >
        <div class="absolute inset-y-0 {{ $side === 'right' ? 'left-0' : 'right-0' }} w-px bg-transparent group-hover/resize:bg-[color:var(--nx-line-strong)] transition"></div>
        <div class="absolute top-1/2 -translate-y-1/2 {{ $side === 'right' ? 'left-0' : 'right-0' }} h-8 w-1 rounded-full bg-transparent group-hover/resize:bg-[color:var(--nx-line-strong)] transition"></div>
    </div>
</div>
