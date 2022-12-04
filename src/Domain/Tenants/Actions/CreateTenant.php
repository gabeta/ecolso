<?php

namespace Domain\Tenants\Actions;

use Domain\Tenants\DataTransferObjects\CreateTenantData;
use Domain\Tenants\Models\Tenant;

class CreateTenant
{
    public function __invoke(CreateTenantData $data): Tenant
    {
        $tenant = Tenant::create([
            'name' => $data->name,
            'database' => $data->database,
            'domain' => $data->domain,
            'description' => $data->description
        ]);

        return $tenant;
    }
}
