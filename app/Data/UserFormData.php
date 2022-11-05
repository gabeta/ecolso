<?php

namespace App\Data;

use Spatie\DataTransferObject\DataTransferObject;

class UserFormData extends DataTransferObject
{

    public readonly String $name;

    public readonly String $email;

    public readonly ?String $password;
}
