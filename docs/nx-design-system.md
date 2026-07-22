# nx Design-System

Framework-weiter, **Notion-inspirierter** Look über die ganze Plattform. Ziel: jedes Modul
sieht gleich aus, unabhängig von Kunden-/ENV-Tokens. `nx` löst schrittweise das alte
`x-ui-*` / `--ui-*`-System ab — **additiv**, Modul für Modul, ohne etwas zu brechen.

> Diese Datei ist die zentrale Referenz. Jede Komponente hat zusätzlich einen Docblock mit
> Props + Beispiel. Beim Hinzufügen einer Komponente: **hier eintragen.**

---

## 1. Prinzipien

- **Env-unabhängige Tokens.** Feste `--nx-*`-Variablen in
  `resources/views/components/ui-styles.blade.php` (`:root`). NICHT aus `config/ui.php`/`.env`.
- **Chrome neutral, Inhalt trägt Farbe.** Sidebars/Actionbar/Terminal sind grau/weiß.
  Farbe lebt *dezent* im Inhalt: Badges, Callouts, Stat-Icons, Standzeit-Klassen-Farben.
  Farbe ist **bedeutungstragend**, nie Deko.
- **Ruhig statt laut.** Hairlines statt Rahmen, keine Schatten (außer Popover/Modal),
  near-black als Akzent, großzügige Luft, „quiet until hover".
- **Reines Tailwind** mit `bg-[color:var(--nx-…)]`. Neue Klassen brauchen `npm run build`;
  reine Token-/Inline-Style-Änderungen nur `php artisan view:clear`.

## 2. Tokens

Grundfläche `--nx-bg` (#f4f3ee, Chrome) · `--nx-surface` (#fff, Content/Cards) ·
Text `--nx-text` (#37352f) · `--nx-muted` · `--nx-faint` ·
Linien `--nx-line` / `--nx-line-strong` · Hover `--nx-hover` / `--nx-active` ·
Akzent `--nx-accent` (near-black) / `--nx-accent-hover` / `--nx-accent-soft` / `--nx-on-accent` ·
Semantik `--nx-success` / `--nx-danger` / `--nx-warning` / `--nx-info` ·
Radius `--nx-radius-sm` (6) / `--nx-radius` (8) / `--nx-radius-lg` (12) ·
`--nx-shadow` (none) / `--nx-shadow-pop` (Popover/Modal).

## 3. Shell-Komponenten (Rahmen, „Eimer 1")

Bereits auf nx-Tokens, bleiben aus Kompatibilität unter `x-ui-*`:
`x-ui-page`, `x-ui-page-navbar`, `x-ui-page-actionbar`, `x-ui-page-container`,
`x-ui-page-sidebar`, `x-ui-sidebar`, `x-ui-breadcrumb`, Terminal.
44px-Raster, fraktales Layout (innere Sidebar volle Höhe, Actionbar daneben).

## 4. Content-Komponenten (`x-nx-*`)

Registriert im `UiTailwindServiceProvider` (explizit, wie alle `x-ui-*`).

| Komponente | Zweck / wichtigste Props |
|---|---|
| `x-nx-card` | Container. `flush` (kein Padding), `hover` |
| `x-nx-button` | `variant` primary/secondary/ghost/danger · `size` sm/md · `icon` · `href` · `disabled` |
| `x-nx-badge` | Status-Pille. `variant` neutral/success/danger/warning/info/accent · `dot` |
| `x-nx-dropdown` (+`-item`, `-divider`) | Aktionsmenü. `label` (sonst Kebab) · `align` · `width`. Item: `href`, `variant`, `disabled` |
| `x-nx-table` (+`-header`, `-header-cell`, `-body`, `-row`, `-cell`) | Tabelle. `compact`, `align`, `sortable`, `hover`, `striped`, `clickable`/`href`. Flush → in `x-nx-card` |
| `x-nx-modal` | Dialog. `size` sm/md/lg/xl · `wire:model` · header/footer-Slots. Wächst mit Inhalt (max-h 85vh) |
| `x-nx-stat` (+`-grid`) | Kennzahl. `label`/`value`/`hint`/`icon`/`accent`/`href`. Grid: `cols` |
| `x-nx-empty` | Leerzustand. `icon` + Slot + `action`-Slot |
| `x-nx-callout` | Notion-Callout. `variant` info/success/warning/danger/neutral · `icon` · `title` · `action`-Slot |
| `x-nx-input-text` / `-number` / `-date` / `-textarea` | Formularfelder. `name`/`label`/`hint`/`size`/`errorKey`/`required`/`placeholder` (+ `min`/`max`/`step`, `rows`). wire:model via $attributes |
| `x-nx-input-select` | Natives Select. `options` (value/label) · `nullable`/`nullLabel` · `optionValue`/`optionLabel` |
| `x-nx-input-checkbox` | Checkbox + Label. `disabled`; wire:model via $attributes |
| `x-nx-bauhaus` | Dekorative generative Grafik. `seed`, `count` |

## 5. Konventionen (verbindlich)

- **Actionbar** = Seitenkopf-Navigation. Links Breadcrumb (Nav), `left`-Slot Inline-Controls
  (Filter/View-Switch), rechts Aktionen: **genau 1 → sichtbarer `x-nx-button`, ≥2 → ein
  `x-nx-dropdown`**. Keine Content-/Bulk-Aktionen rechts.
- **Modal-Größen:** `sm` Bestätigung/1 Feld · `md` Default Formular/Detail · `lg` mehrspaltig
  · `xl` große Tools. Keine Ad-hoc-Breiten.
- **Tabellen/Listen:** rahmenlos auf Weiß, Hairline-Zeilen. **Zeile klickbar = Hauptaktion**;
  Sekundäraktionen als Hover-Icons mit `wire:click.stop`. Header text-forward, keine Icon-Box.
- **Container-Breite:** `x-ui-page-container width="contained"` (max-w 1200, linksbündig) für
  Dashboards/Listen/Formulare; `full` für Kanban/Canvas/breite Tabellen.
- **Farbe:** Chrome neutral. Im Inhalt nur bedeutungstragend (Status → Badge, Hinweis/Attention
  → Callout, KPI-Icon → Semantikfarbe, Timing → Standzeit-Klassen-Farbe).

## 6. Neue Komponente hinzufügen

1. Blade unter `resources/views/components-nx/<name>.blade.php` (mit Docblock: Zweck, Props, Beispiel).
2. In `src/UiTailwindServiceProvider::boot()` registrieren:
   `Blade::component('ui-tailwind::components-nx.<name>', 'nx-<name>');`
3. Hier in Abschnitt 4 eintragen.
4. Nur `bg-[color:var(--nx-…)]` & Semantik-Tokens nutzen — keine `--ui-*`, keine ENV-Farben.

## 7. Deploy

Pakete per `composer update martin3r/platforms-ui-tailwind [modul]` ziehen.
Neue Tailwind-Klassen → `npm run build`. Routen geändert → `php artisan optimize:clear`,
sonst `php artisan view:clear`.
