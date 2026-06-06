<div x-data="sidebarState()" @toggle-main-sidebar.window="toggle()" class="flex">
    <aside
        x-cloak
        :style="collapsed ? 'width: 4rem' : 'width: ' + width + 'px'"
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
    const MIN_WIDTH = 200;
    const MAX_WIDTH = 480;

    return {
        resizing: false,

        get collapsed() {
            return !!this.$store.ui?.g('main_sidebar', 'collapsed');
        },
        get width() {
            const w = this.$store.ui?.g('main_sidebar', 'width') ?? 288;
            return Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, w));
        },

        toggle() {
            this.$store.ui?.gSet('main_sidebar', 'collapsed', !this.collapsed);
        },

        startResize(e) {
            if (this.collapsed) return;
            this.resizing = true;
            const startX = e.clientX;
            const startWidth = this.width;

            const onMouseMove = (ev) => {
                const delta = ev.clientX - startX;
                const next = Math.max(MIN_WIDTH, Math.min(MAX_WIDTH, startWidth + delta));
                this.$store.ui?.gSet('main_sidebar', 'width', next);
            };

            const onMouseUp = () => {
                this.resizing = false;
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            };

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        }
    }
}
</script>
