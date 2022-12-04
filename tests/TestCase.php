<?php

namespace Tests;

use Domain\Tenants\Models\Tenant;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Events\MadeTenantCurrentEvent;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, UsesMultitenancyConfig;

    protected function connectionsToTransact()
    {
        return [
            $this->landlordDatabaseConnectionName(),
            $this->tenantDatabaseConnectionName(),
        ];
    }


    protected function setUp(): void
    {
        parent::setUp();

        Event::listen(MadeTenantCurrentEvent::class, function () {
            $this->beginDatabaseTransaction();
        });

        $this->makeMigration();

        Tenant::first()->makeCurrent();
    }

    /*protected function tearDown(): void
    {
        DB::connection('tenant_testing')->rollBack();
        DB::purge('tenant_testing');

		Tenant::forgetCurrent();

        parent::tearDown();
    }*/

    public function makeMigration(): void
    {
        if (! Schema::connection('landlord_testing')->hasTable('tenants')) {
            $this->artisan('migrate:fresh --database=landlord_testing --path=database/migrations/landlord');

            $tenant = Tenant::factory()->create([
                'database' => 'ecolso_tenant_testing',
                'domain' => 'localhost'
            ]);

            $this->artisan("tenants:artisan 'migrate:fresh --path=database/migrations --database=tenant_testing' --tenant={$tenant->id}");
        }
    }
}
