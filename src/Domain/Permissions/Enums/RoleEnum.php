<?php

namespace Domain\Permissions\Enums;

use ArchTech\Enums\Values;

enum RoleEnum: string
{
    use Values;

    case ADMIN = 'admin'; // IEP
    case INSPECTOR = 'inspector'; // IEP
    case SUPPORT = 'support'; // IEP
    case SECRETARY = 'secretary'; // school
    case DIRECTOR = 'director'; // school
    case TEACHER = 'teacher'; // school
}
