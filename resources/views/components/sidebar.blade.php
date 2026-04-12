<div x-data="sidebarState()" x-init="init()" @toggle-main-sidebar.window="toggle()" class="flex">
    <aside
        x-cloak
        :style="collapsed ? 'width: 4rem' : 'width: ' + sidebarWidth + 'px'"
        :class="resizing ? '' : 'transition-all duration-300'"
        class="shrink-0 h-screen border-r border-[var(--ui-border)]/60 bg-[var(--ui-surface)] flex flex-col relative"
    >
        <!-- Toggle/Header-Bereich (immer sichtbar) -->
        <div class="sticky top-0 z-10 bg-[var(--ui-surface)]/90 backdrop-blur">
            <div class="flex flex-col">
                <!-- Sidebar ein-/ausklappen -->
                <button
                    @click="toggle()"
                    class="flex items-center justify-center h-12 border-b border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
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
            this.syncStore();
            this.$el.addEventListener('toggle-sidebar', () => { this.toggle(); });
        },

        syncStore() {
            if (window.Alpine?.store('page')) {
                Alpine.store('page').mainSidebarOpen = !this.collapsed;
            }
        },

        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar-collapsed', this.collapsed);
            this.syncStore();
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