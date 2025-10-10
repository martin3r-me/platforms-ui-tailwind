<div x-data="sidebarState()" x-init="init()" class="flex">
    <!-- Mobile Overlay -->
    <div 
        x-show="!collapsed && isMobile" 
        @click="collapsed = true"
        class="fixed inset-0 bg-black bg-opacity-50 z-40"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <aside 
        x-cloak
        :class="collapsed ? (isMobile ? 'w-0' : 'w-16') : (isMobile ? 'fixed inset-y-0 left-0 w-80 z-50' : 'w-72')" 
        class="shrink-0 h-screen border-r border-[var(--ui-border)]/60 bg-[var(--ui-surface)] transition-all duration-300 flex flex-col"
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
                    @svg('heroicon-o-squares-2x2', 'w-6 h-6')
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
            <button
                @click="$dispatch('open-modal-comms')"
                class="w-full flex items-center h-14 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                :class="collapsed ? 'justify-center' : 'justify-start px-4 gap-3'"
                title="Kommunikation"
            >
                @svg('heroicon-o-paper-airplane', 'w-5 h-5')
                <span x-show="!collapsed" class="text-sm font-medium">Comms</span>
            </button>
            <!-- Team Trigger -->
            <button
                @click="$dispatch('open-modal-team')"
                class="w-full flex items-center h-14 rounded-none border-t border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                :class="collapsed ? 'justify-center' : 'justify-start px-4 gap-3'"
                title="Team verwalten"
            >
                @svg('heroicon-o-users', 'w-5 h-5')
                <span x-show="!collapsed" class="text-sm font-medium">Team</span>
            </button>

            <!-- User Trigger -->
            <button
                @click="$dispatch('open-modal-user')"
                class="w-full flex items-center h-14 rounded-none border-t border-[var(--ui-border)]/60 text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)] transition-colors"
                :class="collapsed ? 'justify-center' : 'justify-start px-4 gap-3'"
                title="Benutzer-Einstellungen"
            >
                @svg('heroicon-o-user', 'w-5 h-5')
                <span x-show="!collapsed" class="text-sm font-medium">Benutzer</span>
            </button>

            <!-- Terminal Trigger -->
            <button
                @click="window.dispatchEvent(new CustomEvent('toggle-terminal'))"
                class="w-full flex items-center h-14 rounded-none border-t border-[var(--ui-border)]/60 transition-colors"
                :class="(Alpine.store('page')?.terminalOpen ? 'text-[var(--ui-primary)] bg-[var(--ui-muted-5)]' : 'text-[var(--ui-muted)] hover:text-[var(--ui-primary)] hover:bg-[var(--ui-muted-5)]') + ' ' + (collapsed ? 'justify-center' : 'justify-start px-4 gap-3')"
                title="Terminal"
            >
                @svg('heroicon-o-command-line', 'w-5 h-5')
                <span x-show="!collapsed" class="text-sm font-medium">Terminal</span>
            </button>
        </div>
    </aside>
</div>

<script>
function sidebarState() {
    return {
        collapsed: false,
        isMobile: false,
        init() {
            this.collapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            this.isMobile = window.innerWidth < 768;
            this.$el.addEventListener('toggle-sidebar', () => { this.toggle(); });
            
            // Responsive handling
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 768;
                // Auto-collapse on mobile
                if (this.isMobile && !this.collapsed) {
                    this.collapsed = true;
                }
            });
        },
        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar-collapsed', this.collapsed);
        }
    }
}
</script>