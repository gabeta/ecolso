<?php

namespace Tests\Fake;

use Domain\Tenants\Actions\CreateTenantDatabase;
use Domain\Tenants\Models\Tenant;
use Illuminate\Support\Facades\Artisan;

class CreateTenantDatabaseFake extends CreateTenantDatabase
{
    public function migrateDabase(Tenant $tenant): void
    {
        Artisan::call("tenants:artisan 'migrate --path=database/migrations --database=tenant_testing' --tenant={$tenant->id}");
    }
}
