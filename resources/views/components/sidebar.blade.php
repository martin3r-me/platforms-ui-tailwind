<div x-data="sidebarState()" x-init="init()" class="flex">
    <aside 
        x-cloak
        :class="collapsed ? 'w-16' : 'w-72'" 
        class="shrink-0 h-screen bg-black border-r border-[color:var(--ui-border)] transition-all duration-300 flex flex-col overflow-y-auto"
    >
        <!-- Toggle Button (sticky) -->
        <div class="sticky top-0 z-10 bg-black border-b border-[color:var(--ui-border)] p-2">
            <button 
                @click="toggle()" 
                class="flex items-center justify-center transition bg-black hover:bg-[rgba(255,255,255,0.06)] w-full"
                :class="collapsed ? 'w-12' : 'w-full'"
                title="Sidebar umschalten"
            >
                @svg('heroicon-o-bars-3', 'w-6 h-6 text-white')
            </button>
        </div>

        <!-- Quick Actions (nur wenn nicht collapsed) -->
        <div x-show="!collapsed" class="p-2 border-b border-[color:var(--ui-border)]">
            <div class="flex flex-col gap-1" style="padding: 2px;">
                <button 
                    @click="$dispatch('open-modal-modules', { tab: 'modules' })"
                    class="w-full text-left px-3 py-2 hover:bg-[rgba(255,255,255,0.06)] text-sm flex items-center text-white"
                >
                    @svg('heroicon-o-cube', 'w-4 h-4 mr-2 text-white') Module
                </button>
                <button 
                    @click="$dispatch('open-modal-modules', { tab: 'team' })"
                    class="w-full text-left px-3 py-2 hover:bg-[rgba(255,255,255,0.06)] text-sm flex items-center text-white"
                >
                    @svg('heroicon-o-users', 'w-4 h-4 mr-2 text-white') Team
                </button>
                <button 
                    @click="$dispatch('open-modal-modules', { tab: 'account' })"
                    class="w-full text-left px-3 py-2 hover:bg-[rgba(255,255,255,0.06)] text-sm flex items-center text-white"
                >
                    @svg('heroicon-o-user', 'w-4 h-4 mr-2 text-white') Konto
                </button>
                <button 
                    @click="$dispatch('open-modal-modules', { tab: 'billing' })"
                    class="w-full text-left px-3 py-2 hover:bg-[rgba(255,255,255,0.06)] text-sm flex items-center text-white"
                >
                    @svg('heroicon-o-credit-card', 'w-4 h-4 mr-2 text-white') Abrechnung
                </button>
                <button 
                    @click="$dispatch('open-modal-modules', { tab: 'matrix' })"
                    class="w-full text-left px-3 py-2 hover:bg-[rgba(255,255,255,0.06)] text-sm flex items-center text-white"
                >
                    @svg('heroicon-o-table-cells', 'w-4 h-4 mr-2 text-white') Matrix
                </button>
            </div>
        </div>

        <!-- Navigation (eigener Scroll falls lang) -->
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