<?php

namespace App\Tenant;

use App\Tenant\Observers\TenantObserver;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $tenants = ['Team', 'Year'];

        foreach($tenants as $tenant) {
            $this->app->singleton("current{$tenant}", function () {
                return new Tenant();
            });

            $this->app->singleton("App\Tenant\Observers\\{$tenant}Observer", function () use ($tenant) {
                return new ("App\Tenant\Observers\\{$tenant}Observer")(app("current{$tenant}"));
            });

            Request::macro("current{$tenant}", function () use ($tenant) {
                return app("current{$tenant}")->get();
            });
        }

        /*
        Builder::macro('tenable', function () {
            /** @var Builder $this */
            /*return $this->where(app('tenant')->getForeignKey(), app('tenant')->getPrimaryKeyValue());
        });

        Rule::macro('tenable', function ($table, $id) {
            return self::exists($table, $id)->where(app('tenant')->getForeignKey(), app('tenant')->getPrimaryKeyValue());
        });

        Rule::macro('uniqueByTenant', function ($table, $column = null, $ignore = null) {
            $rule = self::unique($table, $column ?? 'NULL')->where(app('tenant')->getForeignKey(), app('tenant')->getPrimaryKeyValue());

            if (is_null($ignore)) {
                return $rule;
            }

            return $rule->ignore($ignore);
        });*/
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Blueprint::macro('tenant', function ($name = null) {
            /** @var Blueprint $this */
            /*$this->foreignId($project = $name ?? 'team_id');
        });*/

        //Blueprint::macro('nullableTenant', function ($name = null) {
            /** @var Blueprint $this */
            /*$this->foreignId($project = $name ?? 'team_id')->nullable();
        });*/
    }
}
