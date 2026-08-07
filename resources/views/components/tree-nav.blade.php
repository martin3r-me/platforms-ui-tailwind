{{--
    x-ui-tree-nav — geteilte Baum-Navigation für die Sidebar (Org-Graph / Betriebe).
    Kompakte, dichte Darstellung + optionale Kontext-Badge je Knoten (z.B. Anzahl Termine).
    Wird von customer / patient / encounter geteilt (eine Quelle, kein Copy-Paste).

    <x-ui-tree-nav :nodes="[['id'=>4,'label'=>'Rheinwerk','depth'=>0,'url'=>route(...),'count'=>3]]"
                   :activeId="$activeId" label="Betriebe" />

      nodes    : array<{id, label, depth, url, icon?, count?}>
      activeId : aktueller Knoten (Highlight)
      label    : optionales Gruppen-Label
--}}
@props([
    'nodes' => [],
    'activeId' => null,
    'label' => null,
])

@if(!empty($nodes))
    <div class="mt-2">
        @if($label)
            <div class="px-3 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wide text-[color:var(--nx-faint)]">
                {{ $label }}
            </div>
        @endif

        <div class="px-1.5 pb-2 space-y-px">
            @foreach($nodes as $node)
                @php($isActive = (string) $activeId === (string) ($node['id'] ?? ''))
                @php($count = $node['count'] ?? null)
                <a href="{{ $node['url'] }}" wire:navigate
                   @class([
                       'group flex items-center gap-1.5 rounded px-1.5 py-1 text-[13px] leading-tight text-[color:var(--nx-text)]',
                       'bg-[color:var(--nx-active)] font-semibold' => $isActive,
                       'hover:bg-[color:var(--nx-hover)]' => !$isActive,
                   ])
                   style="padding-left: {{ 0.375 + ($node['depth'] ?? 0) * 0.6 }}rem">
                    @svg($node['icon'] ?? (($node['depth'] ?? 0) === 0 ? 'heroicon-o-building-office-2' : 'heroicon-o-building-office'), 'w-3.5 h-3.5 shrink-0 text-[color:var(--nx-faint)]')
                    <span class="truncate flex-1 min-w-0">{{ $node['label'] }}</span>
                    @if($count !== null && $count > 0)
                        <span class="shrink-0 min-w-[1.25rem] text-center text-[11px] leading-none px-1.5 py-0.5 rounded-full bg-[color:var(--nx-bg)] text-[color:var(--nx-muted)] group-hover:bg-[color:var(--nx-surface)]">
                            {{ $count }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@endif
