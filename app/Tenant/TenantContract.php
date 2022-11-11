<?php

namespace App\Tenant;

use Illuminate\Database\Eloquent\Model;

interface TenantContract
{
    public function put(Model $tenant);

    public function get();

    public function getPrimaryKeyValue();

    public function getForeignKey();
}
