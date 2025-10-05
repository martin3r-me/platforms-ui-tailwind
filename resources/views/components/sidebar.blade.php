<div x-data="sidebarState()" x-init="init()" class="flex">
    <aside 
        x-cloak
        :class="collapsed ? 'w-16' : 'w-72'" 
        class="shrink-0 h-screen bg-black border-r border-[color:var(--ui-border)] transition-all duration-300 flex flex-col overflow-y-auto"
    >
        <!-- Header: Modul-Trigger + Toggle -->
        <div class="sticky top-0 z-10 bg-black border-b border-[color:var(--ui-border)] p-2">
            <!-- Modul-Modal öffnen -->
            <button 
                @click="$dispatch('open-modal-modules')" 
                class="flex items-center justify-center transition bg-black hover:bg-[rgba(255,255,255,0.06)] w-full mb-2"
                title="Module öffnen"
            >
                @svg('heroicon-o-squares-2x2', 'w-6 h-6 text-white')
            </button>
            <!-- Sidebar ein-/ausklappen -->
            <button 
                @click="toggle()" 
                class="flex items-center justify-center transition bg-black hover:bg-[rgba(255,255,255,0.06)] w-full"
                :title="collapsed ? 'Sidebar ausklappen' : 'Sidebar einklappen'"
            >
                <template x-if="collapsed">
                    @svg('heroicon-o-chevron-double-right', 'w-6 h-6 text-white')
                </template>
                <template x-if="!collapsed">
                    @svg('heroicon-o-chevron-double-left', 'w-6 h-6 text-white')
                </template>
            </button>
        </div>

        <!-- Modul-spezifische Sidebar-Inhalte -->
        <nav class="flex-1 overflow-y-auto p-2 flex flex-col gap-2">
            {{ $slot ?? '' }}
        </nav>
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