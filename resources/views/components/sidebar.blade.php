<div x-data="sidebarState()" x-init="init()" class="flex">
    <aside 
        x-cloak
        :class="collapsed ? 'w-16' : 'w-72'" 
        class="shrink-0 h-screen bg-black border-r border-[color:var(--ui-border)] transition-all duration-300 flex flex-col overflow-y-auto"
    >
        <!-- Toggle Button (öffnet Modul-Modal) -->
        <div class="sticky top-0 z-10 bg-black border-b border-[color:var(--ui-border)] p-2">
            <button 
                @click="$dispatch('open-modal-modules')" 
                class="flex items-center justify-center transition bg-black hover:bg-[rgba(255,255,255,0.06)] w-full"
                :class="collapsed ? 'w-12' : 'w-full'"
                title="Module öffnen"
            >
                @svg('heroicon-o-squares-2x2', 'w-6 h-6 text-white')
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