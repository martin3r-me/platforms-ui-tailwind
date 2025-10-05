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

        // Komponenten vorerst unter neuem Namespace registrieren
        Blade::component('ui-tailwind::components.ui-styles', 'ui-styles');
        Blade::component('ui-tailwind::components.sidebar', 'ui-sidebar');
        Blade::component('ui-tailwind::components.table', 'ui-table');
        Blade::component('ui-tailwind::components.table-header', 'ui-table-header');
        Blade::component('ui-tailwind::components.table-header-cell', 'ui-table-header-cell');
        Blade::component('ui-tailwind::components.table-body', 'ui-table-body');
        Blade::component('ui-tailwind::components.table-row', 'ui-table-row');
        Blade::component('ui-tailwind::components.table-cell', 'ui-table-cell');
        Blade::component('ui-tailwind::components.modal', 'ui-modal');
        Blade::component('ui-tailwind::components.button', 'ui-button');
        Blade::component('ui-tailwind::components.badge', 'ui-badge');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ui.php', 'ui');
        $this->app->register(\BladeUI\Heroicons\BladeHeroiconsServiceProvider::class);
    }
}


