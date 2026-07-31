{{--
    Launchpad-Kachel (Partial, via @include genutzt vom nx-launchpad).
    Params:
      m          : Modul-Array [ key,title,icon,url,group,badge? ]
      groupTones : group→tone Map (aus dem Elternscope geerbt)
      neutral    : bool — neutrale (Chrome-)Kachel statt Gruppenfarbe (default false)
      show       : Alpine-x-show-Expression (default: Suchtreffer-Filter)
--}}
@php
    $neutral = $neutral ?? false;
    $show    = $show ?? "!search || \$el.dataset.title.includes(search.toLowerCase())";

    $title = $m['title'] ?? ucfirst($m['key'] ?? '');
    $icon  = $m['icon'] ?? null;
    if ($icon && ! \Illuminate\Support\Str::startsWith($icon, 'heroicon')) {
        $icon = 'heroicon-o-' . $icon;
    }
    $url   = $m['url'] ?? '#';
    $badge = $m['badge'] ?? null;

    if ($neutral) {
        $tint = 'var(--nx-accent-soft)';
        $mark = 'var(--nx-text)';
        $bord = 'var(--nx-line-strong)';
    } else {
        $group = $m['group'] ?? 'other';
        $tone  = $groupTones[$group] ?? 'slate';
        $tint  = "color-mix(in srgb, var(--nx-tone-{$tone}) 15%, #ffffff)";
        $mark  = "var(--nx-tone-{$tone})";
        $bord  = 'var(--nx-line)';
    }

    // Monogramm-Fallback (1–2 Initialen) für Module ohne Icon.
    $initials = \Illuminate\Support\Str::of($title)
        ->explode(' ')->filter()->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
    if ($initials === '') { $initials = mb_strtoupper(mb_substr($title, 0, 1)); }
@endphp
<a href="{{ $url }}"
    data-title="{{ \Illuminate\Support\Str::lower($title) }}"
    x-show="{{ $show }}"
    @click="close()"
    class="lp-item group flex flex-col items-center gap-2 rounded-[12px] p-2.5 transition-colors hover:bg-[color:var(--nx-hover)]">
    <span class="relative grid h-[60px] w-[60px] place-items-center rounded-[14px] border shadow-[var(--nx-shadow-card)] transition-transform duration-150 group-hover:-translate-y-0.5"
        style="background: {{ $tint }}; color: {{ $mark }}; border-color: {{ $bord }}">
        @if($icon)
            <x-dynamic-component :component="$icon" class="h-7 w-7" />
        @else
            <span class="text-[19px] font-semibold leading-none tracking-tight">{{ $initials }}</span>
        @endif
        @if($badge)
            <span class="absolute -right-1.5 -top-1.5 grid h-5 min-w-[20px] place-items-center rounded-full border-2 border-[color:var(--nx-bg)] bg-[color:var(--nx-danger)] px-1.5 text-[11px] font-semibold text-white">{{ $badge > 99 ? '99+' : $badge }}</span>
        @endif
    </span>
    <span class="max-w-[92px] text-center text-[13px] font-medium leading-tight text-[color:var(--nx-text)]">{{ $title }}</span>
</a>
