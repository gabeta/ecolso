<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant as ModelsTenant;

class Tenant extends ModelsTenant
{
    use UsesLandlordConnection;
    use HasFactory;

    protected $guarded = [];
}
