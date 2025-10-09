<div x-data="sidebarState()" x-init="init()" class="flex">
    <aside 
        x-cloak
        :class="collapsed ? 'w-16' : 'w-72'" 
        class="shrink-0 h-screen border-r border-[var(--ui-border)]/60 bg-[var(--ui-surface)] transition-all duration-300 flex flex-col"
    >
        <!-- Toggle/Header-Bereich (immer sichtbar) -->
        <div class="sticky top-0 z-10 bg-[var(--ui-surface)]/90 backdrop-blur">
            <div class="flex flex-col">
                <!-- Modul-Trigger -->
                <button 
                    @click="$dispatch('open-modal-modules')" 
                    class="flex items-center justify-center h-14 border-b border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                    title="Module öffnen"
                >
                    @svg('heroicon-o-squares-2x2', 'w-6 h-6')
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
            <div class="flex-1 flex items-center justify-center">
                <div class="text-[var(--ui-muted)] text-sm font-semibold tracking-wide -rotate-90 origin-center select-none whitespace-nowrap">
                    {{ strtoupper(explode('.', request()->route()?->getName())[0] ?? 'APP') }}
                </div>
            </div>
        </template>

        <!-- Bottom Actions -->
        <div class="mt-auto sticky bottom-0 z-10 bg-[var(--ui-surface)]/90 backdrop-blur border-t border-[var(--ui-border)]/60">
            <button
                @click="$dispatch('open-modal-comms')"
                class="w-full flex items-center justify-center h-14 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                title="Kommunikation"
            >
                @svg('heroicon-o-paper-airplane', 'w-5 h-5')
            </button>
            <button
                @click="window.dispatchEvent(new CustomEvent('toggle-terminal'))"
                class="w-full flex items-center justify-center h-14 rounded-none border-t border-[var(--ui-border)]/60 transition-colors"
                :class="Alpine.store('page')?.terminalOpen ? 'text-[var(--ui-primary)] bg-[var(--ui-muted-5)]' : 'text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]'"
                title="Terminal"
            >
                @svg('heroicon-o-command-line', 'w-5 h-5')
            </button>
        </div>
    </aside>
</div>

<script>
function sidebarState() {
    return {
        collapsed: false,
        init() {
            this.collapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            this.$el.addEventListener('toggle-sidebar', () => { this.toggle(); });
        },
        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar-collapsed', this.collapsed);
        }
    }
}
</script>