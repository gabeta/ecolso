<?php

namespace App\Data;

use Spatie\DataTransferObject\DataTransferObject;

class TenantFormData extends DataTransferObject
{

    public readonly String $name;

    public readonly String $database;

    public readonly String $domain;

    public readonly ?String $description;

    public readonly ?UserFormData $user;
}
