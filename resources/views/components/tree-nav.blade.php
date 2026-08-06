{{--
    x-ui-tree-nav — geteilte Baum-Navigation für die Sidebar (Org-Graph / Betriebe).
    Rendert eine depth-annotierte Knotenliste als Sidebar-Items mit aktivem Zustand.
    Wird von customer / patient / encounter geteilt (eine Quelle, kein Copy-Paste).

    <x-ui-tree-nav :nodes="[['id'=>4,'label'=>'Rheinwerk','depth'=>0,'url'=>route(...)]]"
                   :activeId="$activeId" label="Betriebe" />

      nodes    : array<{id, label, depth, url, icon?}>
      activeId : aktueller Knoten (Highlight)
      label    : optionales Gruppen-Label
--}}
@props([
    'nodes' => [],
    'activeId' => null,
    'label' => null,
])

@if(!empty($nodes))
    <x-ui-sidebar-list :label="$label">
        @foreach($nodes as $node)
            <x-ui-sidebar-item
                :href="$node['url']"
                :active="(string) $activeId === (string) ($node['id'] ?? '')">
                <span class="flex items-center gap-2 min-w-0" style="padding-left: {{ ($node['depth'] ?? 0) * 0.75 }}rem">
                    @svg($node['icon'] ?? (($node['depth'] ?? 0) === 0 ? 'heroicon-o-building-office-2' : 'heroicon-o-building-office'), 'w-4 h-4 text-[var(--nx-text)] shrink-0')
                    <span class="text-sm truncate">{{ $node['label'] }}</span>
                </span>
            </x-ui-sidebar-item>
        @endforeach
    </x-ui-sidebar-list>
@endif
