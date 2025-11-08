@props([
  'projects' => [],              // Array mit Projekten (id, name, tasks, points, avatar)
  'projectRoute' => null,        // Routenname
])

<div class="grid grid-cols-1 gap-3">
  @forelse($projects as $project)
    @php
      $href = $projectRoute ? route($projectRoute, ['plannerProject' => $project['id'] ?? null]) : null;
    @endphp
    <a @if($href) href="{{ $href }}" @endif class="flex items-center gap-3 p-3 rounded-md border border-[var(--ui-border)] bg-white hover:bg-[var(--ui-muted-5)] transition">
      <div class="w-8 h-8 bg-[var(--ui-primary)] text-[var(--ui-on-primary)] rounded flex items-center justify-center">
        @svg('heroicon-o-folder', 'w-5 h-5')
      </div>
      <div class="flex-1 min-w-0">
        <div class="font-medium truncate">{{ $project['name'] ?? 'Projekt' }}</div>
        <div class="text-xs text-[var(--ui-muted)] truncate">
          {{ $project['subtitle'] ?? '' }}
        </div>
      </div>
      <div class="text-sm text-[var(--ui-secondary)]">
        <span class="mr-4"><strong>{{ $project['tasks'] ?? 0 }}</strong> Aufgaben</span>
        <span class="mr-4"><strong>{{ $project['points'] ?? 0 }}</strong> SP</span>
        @if(isset($project['monthly_minutes']) && $project['monthly_minutes'] > 0)
          <span class="text-[var(--ui-primary)] font-semibold">{{ number_format($project['monthly_minutes'] / 60, 1, ',', '.') }}h</span>
        @elseif(isset($project['total_minutes']) && $project['total_minutes'] > 0)
          <span class="text-[var(--ui-primary)] font-semibold">{{ number_format($project['total_minutes'] / 60, 1, ',', '.') }}h</span>
        @endif
      </div>
    </a>
  @empty
    <div class="p-3 text-sm text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">Keine Projekte gefunden.</div>
  @endforelse
</div>


