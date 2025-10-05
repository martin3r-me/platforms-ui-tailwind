<div x-data="rightSidebarState()" x-init="init()" class="d-flex">
    <aside 
        x-cloak
        :class="collapsed ? 'w-16 is-collapsed' : 'w-96 is-expanded'"
        class="relative flex-shrink-0 h-full bg-white border-left-1 border-left-solid border-muted transition-all duration-300 d-flex flex-col overflow-x-hidden"
    >
        <!-- Toggle -->
        <div class="sticky top-0 z-10 bg-white border-bottom-1 border-muted">
            <button 
                @click="toggle()" 
                class="w-full p-3 d-flex items-center justify-center bg-primary-10 transition"
                title="Sidebar umschalten"
            >
                <x-heroicon-o-chevron-double-right x-show="!collapsed" class="w-6 h-6 text-primary" />
                <x-heroicon-o-chevron-double-left x-show="collapsed" class="w-6 h-6 text-primary" />
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-2 d-flex flex-col gap-2">
            {{ $slot ?? '' }}
        </div>
    </aside>
</div>

<script>
function rightSidebarState() {
    return {
        collapsed: false,
        init() {
            this.collapsed = localStorage.getItem('sidebar-cursor-collapsed') === 'true';
            window.dispatchEvent(new CustomEvent('ui:right-sidebar-toggle', { detail: { collapsed: this.collapsed } }));
        },
        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar-cursor-collapsed', this.collapsed);
            window.dispatchEvent(new CustomEvent('ui:right-sidebar-toggle', { detail: { collapsed: this.collapsed } }));
        }
    }
}
</script>


