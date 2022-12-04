<?php

namespace Domain\Users\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class CreateUserData extends DataTransferObject
{

    public readonly String $name;

    public readonly String $email;

    public readonly ?String $password;
}
