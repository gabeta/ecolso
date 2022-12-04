<?php

namespace Domain\Tenants\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant
{
    use UsesLandlordConnection;
    use HasFactory;

    protected $guarded = [];
}
