<?php

namespace Domain\Tenants\Actions;

use Domain\Tenants\DataTransferObjects\CreateTenantData;
use Domain\Tenants\Models\Tenant;
use Domain\Users\Actions\RegisteredUser;

class CreateNewTenantDomain
{
    public function __construct(
        private CreateTenant $createTenant,
        private CreateTenantDatabase $createTenantDatabase,
        private RegisteredUser $registeredUser
    ) {}

    public function __invoke(CreateTenantData $data): Tenant
    {
        $tenant = ($this->createTenant)($data);

        ($this->createTenantDatabase)($tenant, $data);

        ($this->registeredUser)($data->user);

        return $tenant;
    }
}
