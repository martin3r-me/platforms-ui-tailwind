# Modul-Layout (Hauptsidebar · Seite · Kontext-Panel)

Verbindlicher Grundaufbau jedes Moduls — Ergänzung zu [nx-design-system.md](nx-design-system.md).
Ziel: Menschen gewöhnen sich an **Positionen**, nicht an Inhalte. Darum ist die Hülle überall
gleich; nur die Daten darin wechseln.

> **Status (2026-10-23):** Zielbild, beschlossen. Umsetzung beginnt mit den Kernmodulen (s. u.).
> `integrations` entspricht bei der Hauptsidebar bereits der Vorlage.

---

## 1. Geltungsbereich

Gilt verbindlich für die **Kernmodule**: `organization`, `planner`, `okr`, `forecast`, `sales`,
`infra`, `crm`, `seo`, `brands`, `integrations` — sowie `home` als Sonderfall (§ 5).
Alle anderen Module bleiben vorerst, wie sie sind.

## 2. Drei Flächen, je eine Aufgabe

| Fläche | Aufgabe | Frage, die sie beantwortet |
|---|---|---|
| **Hauptsidebar** (links, Modul-Sidebar) | Navigation | *Wohin gehe ich?* |
| **Seite** (Actionbar + Inhalt) | Arbeit am Gegenstand | *Was sehe / tue ich hier?* |
| **Kontext-Panel** (rechts, nur Detailseiten) | Querschnitt am Datensatz | *Woran hängt das, was ist passiert?* |

Keine Fläche übernimmt die Aufgabe einer anderen: Bearbeitung eines einzelnen Datensatzes
gehört **nicht** in die Hauptsidebar, Navigation **nicht** ins Kontext-Panel.

## 3. Hauptsidebar — immer derselbe Aufbau

Von oben nach unten, feste Reihenfolge:

1. **Kopf** — Modulname.
2. **Seiten des Moduls** — immer vorhanden, immer an derselben Stelle, aktive Seite markiert.
3. **Berechtigte Navigation** — das, was *ich* sehen darf: Einheiten-Baum, meine Projekte,
   verbundene Anbieter … (authz-geführt).
4. *(optional)* **Kontextliste** — z. B. „Für mich freigegeben".

Regeln:
- **Hat ein Modul keine berechtigte Navigation, entfällt Abschnitt 3 ersatzlos** — kein leerer
  Block, kein „hier ist nichts". Weil 1–2 oben stabil bleiben, bricht das die Gewöhnung nicht.
- **Ausnahme:** Ist das Modul fachlich an die Organisation gebunden, der User hat aber keine
  Rechte, steht ein Hinweis („Dir sind keine Einheiten freigegeben") — dort *bedeutet* das Fehlen etwas.
- Eingeklappt: nur Icons; Status-Marker (z. B. Fehlerpunkt) bleiben sichtbar.
- Bausteine: `x-ui-sidebar-list` (`label`), `x-ui-sidebar-item` (`href`/`active` bzw. `type="button"`, `trailing`-Slot).

## 4. Seite und Kontext-Panel

**Keine linken inneren Sidebars** (`x-ui-page-sidebar` links). Deren Inhalte wandern:
- Navigation → Hauptsidebar (§ 3)
- Filter / View-Switch → Actionbar, `left`-Slot
- „Übersicht" / Kennzahlen → in die Seite (Kopf, `x-nx-stat-grid`)

Bestehende linke Sidebars mit echtem Inhalt (z. B. Planner-Projekt-Dashboard) werden **einzeln**
entschieden, nicht pauschal gelöscht.

**Rechts gibt es genau ein Panel: das Kontext-Panel.** Es kommt aus dem **Core**, nicht aus dem Modul.
- Nur auf **Detailseiten** (ein Datensatz im Mittelpunkt) — nicht auf Listen, Dashboards, Boards.
- Gleiche Reiter überall, sichtbar je nachdem, was das Modell kann:
  - **Organisation** — verknüpfte Einheiten (Entity-Links), verknüpfen / lösen per Suche.
    Erscheint automatisch für jedes Modell mit `HasEntityLinks`. Ersetzt das Anhängen
    über das Terminal als Standardweg (Terminal bleibt der schnelle Weg).
    **Nicht im Modul `organization`** — dort *ist* der Datensatz die Einheit, an die man hängt;
    was daran hängt, zeigt die Detailseite selbst.
  - **Aktivität** — echtes Activity-Log.
  - **Notizen / Tags / Zusatzfelder** — über die Querschnitts-Traits (HasNotes, HasTags, HasExtraFields).
- Das Modul liefert nur den Datensatz („das ist mein Kontext-Modell"), kein eigenes Blade — über
  das Event `page-context` (§ 4a).
- **Keine Platzhalter-Panels** („Keine Aktivitäten verfügbar") — gibt es nichts, gibt es kein Panel.

### Kontext-Panel ersetzt das Terminal (beschlossen 2026-10-23)

- **Rechte Sidebar, volle Höhe**, ~400 px, per Ziehen verstellbar (pro User gemerkt).
  ≥ ~1500 px offen; Laptop: eingeklappt als Icon-Leiste (Punkt = hat Inhalt), Klick öffnet als
  Overlay; Mobil: Sheet/Vollbild. Kanban/Canvas starten eingeklappt. Ohne `page-context` keine Leiste.
- **Inhalt = die kontextbezogenen Terminal-Apps:** Verknüpfungen (Organisation, Dimension-Links),
  Zeit, Aktivität, Dateien, Tags, Zusatzfelder, OKR, Comms.
- **Technik:** Das Panel ist eine zweite Hülle über dem vorhandenen `TerminalAppRegistry`
  (`Platform\Core\Terminal\Contracts\TerminalApp`) — Apps werden nicht neu gebaut. Verfügbarkeit
  über `isAvailable(TerminalContext)`, gespeist aus den `apps` von `page-context`.
- **Terminal entfällt:** Chat fliegt raus, Agenda wandert nach `home`. Übergang: Apps erscheinen
  zuerst im Panel, dann werden sie im Terminal ausgeblendet; zuletzt wird das Terminal entfernt.

## 4a. Seitenkontext: `HasPageContext`

**Wann ein Kontext-Panel da ist, entscheidet ein einziges Event:** Steht ein konkretes Modell
hinter der Seite, sendet sie `page-context` mit Modell → Panel (und Terminal-Kontext) da.
Ohne Modell (Liste/Dashboard) sendet sie den Reset → Panel weg.

Jede Seite nutzt dafür den Core-Trait `Platform\Core\Livewire\Concerns\HasPageContext`:

```php
use HasPageContext;

protected function pageContext(): ?Model
{
    return $this->project;          // null = Liste/Dashboard
}

protected function pageContextOptions(): array   // optional, nur Abweichungen
{
    return ['url' => route('planner.projects.show', $this->project), 'source' => 'planner.project.view'];
}
```

- **Apps/Reiter werden aus dem Modell abgeleitet**, nicht pro Seite verdrahtet:
  `LogsActivity` → Aktivität · `HasTags` → Tags · `HasExtraFields` → Zusatzfelder
  (bei `InheritsExtraFields` am Eltern-Modell) · `HasTimeEntries` → Zeiten ·
  `HasKeyResultAncestors` → OKR · `HasEntityLinks` → Organisation · Dateien immer.
  Abweichungen über `'apps' => ['files' => false]`.
- **Keine Einzel-Events mehr von Hand** (`comms`, `terminal:app:*`, `organization`, `keyresult`,
  `extrafields`). Der Trait sendet sie übergangsweise selbst mit, bis Terminal & Modals auf
  `page-context` hören — danach fallen sie weg.
- **Jede Detailseite** (Seite über EIN Inhalts-Objekt) nutzt den Trait — sonst hat sie weder
  Terminal-Kontext noch Kontext-Panel. Listen/Dashboards brauchen nichts: Terminal und Panel
  werden bei jedem Seitenwechsel neu gemountet und starten ohne Kontext.
- **Kein Trait** auf Konfigurationsseiten (Typen, Prompts, Definitionen) und in eingebetteten
  Teil-Komponenten — die würden den Kontext der umgebenden Seite überschreiben.
- Eigenes `rendered()` in der Komponente → dort `$this->dispatchPageContext()` aufrufen.

## 5. Sonderfall `home`

`home` geht von der **Person** aus, nicht von einem Fachobjekt; es sammelt aus anderen Modulen
(Mein Tag, Aufgaben, Agenda, Kalender, Zeiten, Ziele, Inbox, Notizen, Benachrichtigungen).

- **Hauptsidebar: gleiche Form, anderer Inhalt.** Oben die home-Seiten; Abschnitt 3 ist
  **„Meine Module"** (berechtigt, auf Modulebene).
- **Kein Kontext-Panel.** `home` zeigt und verlinkt; bearbeitet wird im Herkunftsmodul —
  dort hängt das Kontext-Panel.
- Die inneren Sidebars von `home` werden einzeln aufgelöst nach § 4 (Filter → Actionbar,
  Zusammenfassung → Seite).

## 6. Zwei Modul-Arten, eine Hülle

| | Hauptsidebar Abschnitt 3 | Kontext-Panel |
|---|---|---|
| **Fachmodul** | berechtigte Navigation (falls vorhanden) | ja, auf Detailseiten |
| **home** | Meine Module | nein |

## 7. Reihenfolge der Umsetzung

0. `HasPageContext` in den Core, Pilot: Planner-Projekt + -Task. ✅
1. Kontext-Panel im Core bauen (zuerst Reiter Organisation + Aktivität), Prototyp an `organization`.
2. Hauptsidebar-Gerüst in den Core (Module liefern nur Daten), `integrations` als Referenz.
3. Kernmodule nachziehen: `planner`, `crm`, dann `okr`, `forecast`, `sales`, `infra`, `seo`, `brands`.
4. `home` nach § 5.
