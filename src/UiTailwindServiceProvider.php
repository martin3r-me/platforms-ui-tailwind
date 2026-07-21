<?php

namespace Platform\UiTailwind;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use BladeUI\Icons\Factory as IconFactory;

class UiTailwindServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ui-tailwind');

        // Optional: Views/Config publishen, aber keine Assets mehr
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/ui-tailwind'),
        ], 'ui-tailwind-views');

        $this->publishes([
            __DIR__ . '/../config/ui.php' => config_path('ui.php'),
        ], 'ui-tailwind-config');

        // Komponenten unter neuem Namespace registrieren
        Blade::component('ui-tailwind::components.ui-styles', 'ui-styles');
        Blade::component('ui-tailwind::components.button', 'ui-button');
        Blade::component('ui-tailwind::components.badge', 'ui-badge');
        Blade::component('ui-tailwind::components.label', 'ui-label');

        Blade::component('ui-tailwind::components.sidebar', 'ui-sidebar');
        Blade::component('ui-tailwind::components.right-sidebar', 'ui-right-sidebar');
        Blade::component('ui-tailwind::components.sidebar-module-header', 'sidebar-module-header');
        Blade::component('ui-tailwind::components.task-layout', 'ui-task-layout');
        Blade::component('ui-tailwind::components.sidebar-list', 'ui-sidebar-list');
        Blade::component('ui-tailwind::components.sidebar-item', 'ui-sidebar-item');

        Blade::component('ui-tailwind::components.modal', 'ui-modal');
        Blade::component('ui-tailwind::components.confirm-button', 'ui-confirm-button');

        Blade::component('ui-tailwind::components.table', 'ui-table');
        Blade::component('ui-tailwind::components.table-header', 'ui-table-header');
        Blade::component('ui-tailwind::components.table-header-cell', 'ui-table-header-cell');
        Blade::component('ui-tailwind::components.table-body', 'ui-table-body');
        Blade::component('ui-tailwind::components.table-row', 'ui-table-row');
        Blade::component('ui-tailwind::components.table-cell', 'ui-table-cell');

        Blade::component('ui-tailwind::components.tab', 'ui-tab');
        Blade::component('ui-tailwind::components.grouped-list', 'ui-grouped-list');
        Blade::component('ui-tailwind::components.grouped-list-item', 'ui-grouped-list-item');
        Blade::component('ui-tailwind::components.toast', 'ui-toast');
        Blade::component('ui-tailwind::components.dashboard-tile', 'ui-dashboard-tile');
        Blade::component('ui-tailwind::components.segmented-toggle', 'ui-segmented-toggle');
        Blade::component('ui-tailwind::components.info-banner', 'ui-info-banner');
        Blade::component('ui-tailwind::components.team-members-list', 'ui-team-members-list');
        Blade::component('ui-tailwind::components.project-list', 'ui-project-list');
        Blade::component('ui-tailwind::components.page-header', 'ui-page-header');
        Blade::component('ui-tailwind::components.page-navbar', 'ui-page-navbar');
        Blade::component('ui-tailwind::components.page', 'ui-page');
        Blade::component('ui-tailwind::components.page-sidebar', 'ui-page-sidebar');
        Blade::component('ui-tailwind::components.page-actionbar', 'ui-page-actionbar');
        Blade::component('ui-tailwind::components.page-container', 'ui-page-container');
        Blade::component('ui-tailwind::components.terminal', 'ui-terminal');
        Blade::component('ui-tailwind::components.stats-grid', 'ui-stats-grid');
        Blade::component('ui-tailwind::components.detail-stats-grid', 'ui-detail-stats-grid');
        Blade::component('ui-tailwind::components.panel', 'ui-panel');
        Blade::component('ui-tailwind::components.form-grid', 'ui-form-grid');
        Blade::component('ui-tailwind::components.form.container', 'ui-form-container');
        Blade::component('ui-tailwind::components.tasks-info-sidebar', 'ui-tasks-info-sidebar');

        // Form Inputs
        Blade::component('ui-tailwind::components.form.input-text', 'ui-input-text');
        Blade::component('ui-tailwind::components.form.input-textarea', 'ui-input-textarea');
        Blade::component('ui-tailwind::components.form.input-select', 'ui-input-select');
        Blade::component('ui-tailwind::components.form.input-checkbox', 'ui-input-checkbox');
        Blade::component('ui-tailwind::components.form.input-date', 'ui-input-date');
        Blade::component('ui-tailwind::components.form.input-date-select', 'ui-input-date-select');
        Blade::component('ui-tailwind::components.form.input-datetime', 'ui-input-datetime');
        Blade::component('ui-tailwind::components.form.input-number', 'ui-input-number');
        Blade::component('ui-tailwind::components.form.input-signature', 'ui-input-signature');

        // Kanban
        Blade::component('ui-tailwind::components.kanban.container', 'ui-kanban-container');
        Blade::component('ui-tailwind::components.kanban.board', 'ui-kanban-board');
        Blade::component('ui-tailwind::components.kanban.column', 'ui-kanban-column');
        Blade::component('ui-tailwind::components.kanban.card', 'ui-kanban-card');
        Blade::component('ui-tailwind::components.kanban.board-view', 'ui-kanban-board-view');
        Blade::component('ui-tailwind::components.kanban.list-view', 'ui-kanban-list-view');
        Blade::component('ui-tailwind::components.kanban.list-column', 'ui-kanban-list-column');

        // Navigation & Status
        Blade::component('ui-tailwind::components.breadcrumb', 'ui-breadcrumb');
        Blade::component('ui-tailwind::components.status-toggle', 'ui-status-toggle');

        // ===== nx — festes Notion-Design-System (opt-in pro Modul) =====
        // Anonyme Komponenten aus resources/views/components-nx/ → <x-nx-*>.
        // Additiv neben den bestehenden x-ui-*; nichts Altes wird angefasst.
        Blade::anonymousComponentPath(__DIR__ . '/../resources/views/components-nx', 'nx');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ui.php', 'ui');
        $this->app->register(\BladeUI\Heroicons\BladeHeroiconsServiceProvider::class);

        $this->app->singleton('safe-svg', function () {
            return new class {
                /**
                 * Validates that an icon name is a safe, renderable SVG identifier.
                 * Returns null if the name contains emoji, multibyte chars, or is not a valid heroicon.
                 */
                public function resolve(?string $icon, string $prefix = ''): ?string
                {
                    if ($icon === null || $icon === '') {
                        return null;
                    }

                    // Reject anything with multibyte/emoji characters (valid icon names are ASCII-only)
                    if (preg_match('/[^\x20-\x7E]/', $icon)) {
                        return null;
                    }

                    // Only allow alphanumeric, hyphens, and dots (standard icon name chars)
                    if (!preg_match('/^[a-zA-Z0-9\-\.]+$/', $icon)) {
                        return null;
                    }

                    $fullName = $prefix ? $prefix . $icon : $icon;

                    try {
                        app(IconFactory::class)->svg($fullName);
                        return $icon;
                    } catch (\Exception $e) {
                        return null;
                    }
                }
            };
        });
    }
}


