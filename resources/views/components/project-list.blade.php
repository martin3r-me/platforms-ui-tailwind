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
      <img src="{{ $project['avatar'] ?? asset('project.png') }}" alt="Icon" class="w-8 h-8 rounded object-cover"/>
      <div class="flex-1 min-w-0">
        <div class="font-medium truncate">{{ $project['name'] ?? 'Projekt' }}</div>
        <div class="text-xs text-[var(--ui-muted)] truncate">{{ $project['subtitle'] ?? '' }}</div>
      </div>
      <div class="text-sm text-[var(--ui-secondary)]">
        <span class="mr-4"><strong>{{ $project['tasks'] ?? 0 }}</strong> Aufgaben</span>
        <span><strong>{{ $project['points'] ?? 0 }}</strong> SP</span>
      </div>
    </a>
  @empty
    <div class="p-3 text-sm text-[var(--ui-muted)] bg-white rounded-md border border-[var(--ui-border)]">Keine Projekte gefunden.</div>
  @endforelse
</div>


