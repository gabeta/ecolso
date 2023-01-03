<?php

namespace Domain\Users\DataTransferObjects;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

class CreateUserData extends DataTransferObject
{
    public readonly String $name;

    public readonly String $email;

    public readonly ?String $password;

    public readonly Collection $roles;

    public readonly bool $is_super_admin;
}
