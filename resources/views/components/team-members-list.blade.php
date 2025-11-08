@props([
  'members' => [], // Array von ['name' => '...', 'tasks' => 0, 'points' => 0, 'avatar' => url]
])

<div class="divide-y divide-[var(--ui-border)] border border-[var(--ui-border)] rounded-md overflow-hidden">
  @forelse($members as $member)
    <div class="flex items-center gap-3 p-3 bg-white">
      <div class="w-8 h-8 bg-[var(--ui-primary)] text-[var(--ui-on-primary)] rounded-full flex items-center justify-center">
        @svg('heroicon-o-user', 'w-5 h-5')
      </div>
      <div class="flex-1 min-w-0">
        <div class="font-medium truncate">{{ $member['name'] ?? 'Unbekannt' }}</div>
        <div class="text-xs text-[var(--ui-muted)]">
          {{ $member['role'] ?? '' }}
        </div>
      </div>
      <div class="text-sm text-[var(--ui-secondary)]">
        <span class="mr-4"><strong>{{ $member['tasks'] ?? 0 }}</strong> Aufgaben</span>
        <span class="mr-4"><strong>{{ $member['points'] ?? 0 }}</strong> SP</span>
        @if(isset($member['monthly_minutes']) && $member['monthly_minutes'] > 0)
          <span class="text-[var(--ui-primary)] font-semibold">{{ number_format($member['monthly_minutes'] / 60, 1, ',', '.') }}h</span>
        @elseif(isset($member['total_minutes']) && $member['total_minutes'] > 0)
          <span class="text-[var(--ui-primary)] font-semibold">{{ number_format($member['total_minutes'] / 60, 1, ',', '.') }}h</span>
        @endif
      </div>
    </div>
  @empty
    <div class="p-3 text-sm text-[var(--ui-muted)] bg-white">Keine Mitglieder gefunden.</div>
  @endforelse
</div>


