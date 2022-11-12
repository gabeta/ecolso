<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class TypeOfRoom extends Pivot
{
    use UsesTenantConnection;
    use HasFactory;

    protected $guarded = [];
}
