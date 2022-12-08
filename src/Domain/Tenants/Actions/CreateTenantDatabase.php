<?php

namespace Domain\Tenants\Actions;

use Domain\Tenants\DataTransferObjects\CreateTenantData;
use Domain\Tenants\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask;
use Tests\Fake\CreateTenantDatabaseFake;

class CreateTenantDatabase
{
    public function __invoke(Tenant $tenant, CreateTenantData $data): void
    {
        DB::unprepared("CREATE DATABASE IF NOT EXISTS $data->database;");

        $tenant->makeCurrent($tenant);

        $this->migrateDabase($tenant);
    }

    public function migrateDabase(Tenant $tenant): void
    {
        Artisan::call("tenants:artisan --tenant={$tenant->id} -- \"migrate --database=tenant\"");
    }

    public static function fake(): void
    {
        app()->instance(self::class, new CreateTenantDatabaseFake());
    }
}
