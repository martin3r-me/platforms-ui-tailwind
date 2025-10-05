<?php

namespace Platform\UiTailwind;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::component('ui-tailwind::components.stats-grid', 'ui-stats-grid');
        Blade::component('ui-tailwind::components.detail-stats-grid', 'ui-detail-stats-grid');
        Blade::component('ui-tailwind::components.panel', 'ui-panel');

        // Form Inputs
        Blade::component('ui-tailwind::components.form.input-text', 'ui-input-text');
        Blade::component('ui-tailwind::components.form.input-textarea', 'ui-input-textarea');
        Blade::component('ui-tailwind::components.form.input-select', 'ui-input-select');
        Blade::component('ui-tailwind::components.form.input-checkbox', 'ui-input-checkbox');
        Blade::component('ui-tailwind::components.form.input-date', 'ui-input-date');
        Blade::component('ui-tailwind::components.form.input-number', 'ui-input-number');

        // Kanban
        Blade::component('ui-tailwind::components.kanban.board', 'ui-kanban-board');
        Blade::component('ui-tailwind::components.kanban.column', 'ui-kanban-column');
        Blade::component('ui-tailwind::components.kanban.card', 'ui-kanban-card');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ui.php', 'ui');
        $this->app->register(\BladeUI\Heroicons\BladeHeroiconsServiceProvider::class);
    }
}


