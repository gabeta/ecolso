<?php

namespace Domain\Tenants\DataTransferObjects;

use Domain\Users\DataTransferObjects\CreateUserData;
use Spatie\DataTransferObject\DataTransferObject;

class CreateTenantData extends DataTransferObject
{

    public readonly String $name;

    public readonly String $database;

    public readonly String $domain;

    public readonly ?String $description;

    public readonly ?CreateUserData $user;
}
