@props([
  'summary' => [], // ['open' => 0, 'done' => 0, 'frogs' => 0]
])

<aside class="rounded-md border border-[var(--ui-border)] bg-white p-3">
  <h4 class="text-sm font-semibold text-[var(--ui-secondary)] mb-2">Aufgaben-Info</h4>
  <ul class="space-y-1 text-sm">
    <li class="flex justify-between"><span>Offen</span><strong>{{ $summary['open'] ?? 0 }}</strong></li>
    <li class="flex justify-between"><span>Erledigt</span><strong>{{ $summary['done'] ?? 0 }}</strong></li>
    <li class="flex justify-between"><span>Frösche</span><strong>{{ $summary['frogs'] ?? 0 }}</strong></li>
  </ul>
</aside>


