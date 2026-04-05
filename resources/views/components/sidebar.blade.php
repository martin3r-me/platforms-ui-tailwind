<div x-data="sidebarState()" x-init="init()" class="flex">
    <aside
        x-cloak
        :style="collapsed ? 'width: 4rem' : 'width: ' + sidebarWidth + 'px'"
        :class="resizing ? '' : 'transition-all duration-300'"
        class="shrink-0 h-screen border-r border-[var(--ui-border)]/60 bg-[var(--ui-surface)] flex flex-col relative"
    >
        <!-- Toggle/Header-Bereich (immer sichtbar) -->
        <div class="sticky top-0 z-10 bg-[var(--ui-surface)]/90 backdrop-blur">
            <div class="flex flex-col">
                <!-- Modul-Trigger -->
                <button 
                    @click="$dispatch('open-modal-modules')" 
                    class="flex items-center h-14 border-b border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                    :class="collapsed ? 'justify-center' : 'justify-start px-4 gap-3'"
                    title="Module öffnen"
                >
                    @if (file_exists(public_path('logo_square.png')))
                        <img src="{{ asset('logo_square.png') }}" alt="Logo" class="w-6 h-6 rounded-md" />
                    @else
                        @svg('heroicon-o-squares-2x2', 'w-6 h-6')
                    @endif
                    <span x-show="!collapsed" class="text-sm font-medium">Module</span>
                </button>

                <!-- Sidebar ein-/ausklappen -->
                <button 
                    @click="toggle()" 
                    class="flex items-center justify-center h-14 border-b border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                    :title="collapsed ? 'Sidebar ausklappen' : 'Sidebar einklappen'"
                >
                    <template x-if="collapsed">
                        @svg('heroicon-o-chevron-double-right', 'w-5 h-5')
                    </template>
                    <template x-if="!collapsed">
                        @svg('heroicon-o-chevron-double-left', 'w-5 h-5')
                    </template>
                </button>
            </div>
        </div>

        <!-- Modul-spezifische Sidebar-Inhalte -->
        <template x-if="!collapsed">
            <nav class="flex-1 overflow-y-auto p-3 flex flex-col gap-2">
                {{ $slot ?? '' }}
            </nav>
        </template>
        <template x-if="collapsed">
            <button 
                @click="toggle()"
                class="flex-1 w-full flex items-center justify-center hover:bg-[var(--ui-muted-5)]"
                title="Sidebar ausklappen"
            >
                <div class="text-[var(--ui-muted)] text-sm font-semibold tracking-wide -rotate-90 origin-center select-none whitespace-nowrap">
                    {{ strtoupper(explode('.', request()->route()?->getName())[0] ?? 'APP') }}
                </div>
            </button>
        </template>

        <!-- Bottom Actions -->
        <div class="mt-auto sticky bottom-0 z-10 bg-[var(--ui-surface)]/90 backdrop-blur border-t border-[var(--ui-border)]/60">
            <!-- Terminal Trigger -->
            <button
                @click="window.dispatchEvent(new CustomEvent('toggle-terminal'))"
                class="w-full flex items-center h-9 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                :class="(Alpine.store('page')?.terminalOpen ? 'text-[var(--ui-primary)] bg-[var(--ui-muted-5)]' : '') + ' ' + (collapsed ? 'justify-center' : 'justify-start px-4 gap-3')"
                title="Terminal"
            >
                @svg('heroicon-o-command-line', 'w-5 h-5')
                <span x-show="!collapsed" class="text-sm font-medium">Terminal</span>
            </button>
        </div>

        <!-- Resize handle (right edge) -->
        <div
            x-show="!collapsed"
            @mousedown.prevent="startResize($event)"
            class="absolute top-0 right-0 w-1 h-full cursor-ew-resize group/resize z-20"
        >
            <div class="absolute inset-y-0 right-0 w-px bg-transparent group-hover/resize:bg-[var(--ui-primary)]/40 transition"></div>
            <div class="absolute top-1/2 -translate-y-1/2 right-0 h-8 w-1 rounded-full bg-transparent group-hover/resize:bg-[var(--ui-primary)]/30 transition"></div>
        </div>
    </aside>
</div>

<script>
function sidebarState() {
    const STORAGE_KEY = 'sidebar-width';
    const DEFAULT_WIDTH = 288;
    const MIN_WIDTH = 200;
    const MAX_WIDTH = 480;

    return {
        collapsed: false,
        sidebarWidth: parseInt(localStorage.getItem(STORAGE_KEY)) || DEFAULT_WIDTH,
        resizing: false,

        init() {
            this.collapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            this.sidebarWidth = Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, this.sidebarWidth));
            this.$el.addEventListener('toggle-sidebar', () => { this.toggle(); });
        },

        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar-collapsed', this.collapsed);
        },

        startResize(e) {
            if (this.collapsed) return;
            this.resizing = true;
            const startX = e.clientX;
            const startWidth = this.sidebarWidth;

            const onMouseMove = (ev) => {
                const delta = ev.clientX - startX;
                this.sidebarWidth = Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, startWidth + delta));
            };

            const onMouseUp = () => {
                this.resizing = false;
                localStorage.setItem(STORAGE_KEY, this.sidebarWidth);
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            };

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }
    }
}
</script>