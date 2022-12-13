<?php

namespace App\Providers;

use App\Macros\Collection\Selectable;
use App\Macros\Redirector\AppRoute;
use App\Macros\UrlGenerator\AppRoute as UrlGeneratorAppRoute;
use App\Table\InertiaTable;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('selectable', app(Selectable::class)());

        Redirector::macro('appRoute', app(AppRoute::class)());

        UrlGenerator::macro('appRoute', app(UrlGeneratorAppRoute::class)());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('table', function (callable $withTableBuilder = null) {
            $tableBuilder = new InertiaTable(request());

            if ($withTableBuilder) {
                $withTableBuilder($tableBuilder);
            }

            return $tableBuilder->applyTo($this);
        });
    }
}
