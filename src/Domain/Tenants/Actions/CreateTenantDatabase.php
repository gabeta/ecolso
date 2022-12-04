<?php

namespace Domain\Tenants\Actions;

use Domain\Tenants\DataTransferObjects\CreateTenantData;
use Domain\Tenants\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask;

class CreateTenantDatabase
{
    public function __invoke(Tenant $tenant, CreateTenantData $data): void
    {
        DB::unprepared("CREATE DATABASE IF NOT EXISTS $data->database;");

        Artisan::call("tenants:artisan --tenant={$tenant->id} -- \"migrate --database=tenant\"");

        app(SwitchTenantDatabaseTask::class)->makeCurrent($tenant);
    }
}
